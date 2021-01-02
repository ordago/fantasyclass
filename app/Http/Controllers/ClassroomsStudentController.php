<?php

namespace App\Http\Controllers;

use App\Badge;
use App\Card;
use App\CardStudent;
use App\Challenge;
use App\ChallengesGroup;
use App\Classroom;
use App\ClassroomUser;
use App\Equipment;
use App\Http\Classes\Functions;
use App\Item;
use App\LogEntry;
use App\Student;
use App\Map;
use App\Notifications\NewInteractionStudent;
use App\Pet;
use App\Rating;
use App\Rules;
use Arcanedev\LaravelSettings\Utilities\Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ClassroomsStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }


    public function updateavatar($code)
    {

        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        $data = request()->validate([
            'avatar' => ['image', 'nullable'],
            'url' => ['string', 'nullable'],
            'student_id' => ['numeric', 'nullable'],
        ]);

        if (request()->student_id) {
            $user = auth()->user();

            if (!$user->classrooms->where('id', $class->id)->where('pivot.role', '>', 0)->first()) {
                return false;
            }
            $student = Student::where('id', $data['student_id'])->firstOrFail();
            if ($student->classroom->classroom_id != $class->id) {
                return false;
            }
        } else {
            $student = Functions::getCurrentStudent($class, []);
        }

        if (isset($data['url'])) {
            $student->update(['avatar_url' => $data['url']]);
            $avatar = $student->getMedia('avatar');
            if (count($avatar))
                $avatar[0]->delete();
        } else {
            settings()->setExtraColumns(['classroom_id' => $class->id]);
            $student->update(['avatar_url' => null]);
            $student->addMedia(request()->file('avatar'))
                ->toMediaCollection('avatar');

            $avatarPath = $student->getMedia('avatar')->first();
            $imgPath = $avatarPath->collection_name . "/" . $avatarPath->uuid . '/' . $avatarPath->file_name;
            $path = Storage::disk('public')->path('/') . $imgPath;
            Image::make($path)->resize(128, 128)->save();
        }
    }

    public function checkVisibility($class)
    {
        settings()->setExtraColumns(['classroom_id' => $class]);
        settings()->get('state', 0);
        if (settings()->get('state', 0) == 2)
            abort(403);
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->with('students.equipment', 'students.pets', 'students.groups', 'theme')->firstOrFail();
        $this->checkVisibility($class->id);
        $this->authorize('studyOrTeach', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);

        $student = Functions::getCurrentStudent($class);

        $class->students->each->append('grouplogopublic');
        $students = $class->students->where('hidden', '=', 0)->map(function ($user) {
            return collect($user->toArray())
                ->only(['avatar', 'username', 'grouplogopublic', 'name', 'xp', 'hp', 'gold', 'equipment', 'pets', 'level', 'groups'])
                ->all();
        });

        $rating = 0;
        $count = 0;
        foreach ($class->challengeGroups as $challengegr) {
            foreach ($challengegr->challenges as $challenge) {
                if ($challenge->rating) {
                    $rating += $challenge->rating;
                    $count++;
                }
            }
        }
        if ($count == 0) {
            $rating = 0;
        } else $rating = $rating / $count;

        $monsters = $class->monsters;

        $chat['title'] = sha1(env('CHAT_KEY') . $class->id);
        $chat['url'] = env('APP_URL_SHORT');
        $chat['chatbro_id'] = env('CHATBRO_ID');
        $chat['id'] = auth()->user()->id . '-' . $student->id;
        $chat['name'] = $student->name;
        if (strpos($student->avatar, "http") !== false)
            $chat['avatar'] = $student->avatar;
        else $chat['avatar'] = env('APP_URL') . $student->avatar;

        $chat['signature'] = md5(env('APP_URL_SHORT') . $chat['id'] . $chat['name'] . $chat['avatar'] . env('CHATBRO_KEY'));
        $showChat = settings()->get('show_chat', false);

        return view('studentsview.index', compact('class', 'student', 'students', 'chat', 'showChat', 'monsters', 'rating'));
    }

    public function challenges($code)
    {
        $class = Classroom::where('code', '=', $code)->with('challengeGroups')->firstOrFail();
        $this->checkVisibility($class->id);
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class, []);
        $challenges = [];


        foreach ($class->challengeGroups as $group) {
            array_push($challenges, $group->challenges()->with('attachments', 'comments', 'group')->where('datetime', '<=', Carbon::now('Europe/Madrid')->toDateTimeString())->get()->append('questioninfo')->map(function ($challenge) {
                return collect($challenge->toArray())
                    ->only(['id', 'title', 'xp', 'hp', 'gold', 'datetime', 'content', 'icon', 'color', 'is_conquer', 'cards', 'students', 'items', 'attachments', 'comments', 'group', 'questioninfo', 'challenge_required', 'requirements'])
                    ->all();
            }));
        }

        $all = [];
        foreach ($challenges as $section) {
            foreach ($section as $key => $value) {
                if ($value['challenge_required']) {
                    if (!$student->challenges->contains($value['challenge_required'])) {
                        unset($section[$key]);
                        continue;
                    }
                }

                if ($value['requirements'] && !$student->challenges->contains($value['id'])) {
                    $allItems = true;
                    $content = '';
                    foreach ($value['requirements'] as $item) {
                        if (!$student->items->contains($item['id'])) {
                            $allItems = false;
                            $content .= "<img class='coloredGray m-2' title='". $item['alt'] ."' alt='". $item['alt'] ."' src='" . $item['src'] . "' width='48px'>";
                        } else {
                            $content .= "<img class='m-2' title='". $item['alt'] ."' alt='". $item['alt'] ."' src='" . $item['src'] . "' width='48px'>";
                        }
                    }
                    if (!$allItems) {
                        $value['title'] = __('challenges.objects_required');
                        $value['content'] = $content;
                        $value['incomplete'] = true;
                    }
                }

                if (Rating::where('student_id', $student->id)->where('challenge_id', $value['id'])->get()->count()) {
                    $value['rated'] = 1;
                } else $value['rated'] = 0;
                $students = $value['students'];
                if (!$students || array_search($student->id, $students) === false)
                    array_push($all, $value);
            }
        }
        $challenges = Arr::sort($all, function ($story) {
            return $story['datetime'];
        });

        return view('studentsview.challenges', compact('class', 'student', 'challenges'));
    }

    public function getChallenge($code, $permalink)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $student = Functions::getCurrentStudent($class, []);
        $this->checkVisibility($class->id);
        $this->authorize('studyOrTeach', $class);
        $challenge = Challenge::where('id', '=', Crypt::decryptString($permalink))->with('attachments', 'group', 'comments')->first();

        return view('studentsview.challenge', compact('challenge', 'class', 'student'));
    }
    public static function getChallenges($student, $class, $admin = false)
    {
        $challenges = DB::table('students')
            ->crossJoin('challenges')
            ->where('challenges.is_conquer', '=', 1)
            ->where('challenges.type', '=', 0)
            ->whereRaw('not JSON_CONTAINS(challenges.students, ?)', [json_encode($student->id)])
            ->where('challenges.datetime', '<=', Carbon::now('Europe/Madrid')->toDateTimeString())
            ->whereIn('challenges.id', function ($query) use ($class) {
                $query->select('challenges.id')
                    ->from('challenges')
                    ->join('challenges_groups', 'challenges_groups.id', 'challenges.challenges_group_id')
                    ->where('challenges_groups.classroom_id', '=', $class->id)
                    ->get();
            })
            ->where('students.id', '=', $student->id)
            ->leftJoin('challenge_student', function ($join) use ($student) {
                $join->on('challenges.id', '=', 'challenge_student.challenge_id')
                    ->where('challenge_student.student_id', '=', $student->id);
            })
            ->selectRaw('challenges.id, challenges.type, challenges.is_conquer, challenges.items, challenges.title, challenges.description, challenges.datetime, challenges.icon, challenges.color, challenges.xp, challenges.hp, challenges.gold, challenges.cards, challenges.completion, challenges.optional, challenge_student.count, challenges.challenge_required, challenges.challenges_group_id, challenges.requirements')
            ->get();


        $groups = $student->groups->pluck('id');

        $groupChallenges = DB::table('groups')
            ->crossJoin('challenges')
            ->where('challenges.is_conquer', '=', 1)
            ->where('challenges.type', '=', 1)
            ->where('challenges.datetime', '<=', Carbon::now('Europe/Madrid')->toDateTimeString())
            ->whereIn('challenges.challenges_group_id', function ($query) use ($class) {
                $query->select('challenges_groups.id')
                    ->from('challenges_groups')
                    ->where('challenges_groups.classroom_id', '=', $class->id)
                    ->get();
            })
            ->whereIn('groups.id', $groups)
            ->leftJoin('challenge_group', function ($join) use ($groups) {
                $join->on('challenges.id', '=', 'challenge_group.challenge_id')
                    ->whereIn('challenge_group.group_id', $groups);
            })
            ->selectRaw('challenge_group.group_id, challenges.id, challenges.type, challenges.items, challenges.is_conquer, challenges.title, challenges.description, challenges.datetime, challenges.icon, challenges.color, challenges.xp, challenges.hp, challenges.gold, challenges.cards, challenges.completion, challenges.optional, challenge_group.count, challenges.challenge_required, challenges.challenges_group_id, challenges.requirements')
            ->get()->all();

        $challenges = $challenges->merge($groupChallenges);
        foreach ($challenges as $key => $challenge) {
            $challenge->items = json_decode($challenge->items);
            if ($challenge->challenge_required) {
                if (!$student->challenges->contains($challenge->challenge_required)) {
                    unset($challenges[$key]);
                    continue;
                }
            }
            if ($challenge->requirements && !$admin && !$student->challenges->contains($challenge->id)) {
                $continue = false;
                foreach (json_decode($challenge->requirements) as $item) {
                    if (!$student->items->contains($item->id)) {
                        unset($challenges[$key]);
                        $continue = true;
                    }
                }
                if($continue)
                    continue;
            }
            $challenge->permalink = Crypt::encryptString($challenge->id);
            $group = ChallengesGroup::find($challenge->challenges_group_id);
            $challenge->group = [
                'name' => $group->name,
                'icon' => $group->icon,
            ];
        }
        return $challenges;
    }

    public function show($code)
    {
        $class = Classroom::where('code', '=', $code)->with('theme', 'characterTheme.characters')->firstOrFail();
        $this->checkVisibility($class->id);
        $this->authorize('studyOrTeach', $class);
        $admin = false;
        $student = Functions::getCurrentStudent($class);

        $student->append('numcards');

        // Shop information
        settings()->setExtraColumns(['classroom_id' => $class->id]);

        $items = $eq1 = $eq2 = $eq3 = null;
        if (settings()->get('items_visibility', false) ? true : false) {
            $items = Item::where('classroom_id', '=', $class->id)->where('for_sale', '=', '1')->get();
        }
        if (settings()->get('equipment_1_visibility', false) ? true : false) {
            $eq1 = Equipment::where('character_id', '=', $student->character_id)->where('offset', '=', 1)->get();
        }
        if (settings()->get('equipment_2_visibility', false) ? true : false) {
            $eq2 = Equipment::where('character_id', '=', $student->character_id)->where('offset', '=', 2)->get();
        }
        if (settings()->get('equipment_3_visibility', false) ? true : false) {
            $eq3 = Equipment::where('character_id', '=', $student->character_id)->where('offset', '=', 3)->get();
        }

        $pets = Pet::where('classroom_id', $class->id)->where('for_sale', 1)->get();

        $shop = [
            'items' => json_encode($items),
            'eq1' => json_encode($eq1),
            'eq2' => json_encode($eq2),
            'eq3' => json_encode($eq3),
            'multiplier1' => (float) settings()->get('shop_multiplier_1', 1),
            'multiplier2' => (float) settings()->get('shop_multiplier_2', 1),
            'multiplier3' => (float) settings()->get('shop_multiplier_3', 1),
        ];

        $challenges = $this::getChallenges($student, $class);

        $cards = $student->cards;
        $student->append('boost');
        $student->load('badges');
        foreach ($student->getAutomaticBadges() as $badge) {
            $student->badges->push($badge);
        }

        $student->load('pets');
        $student->load('blogs');

        $evaluation = null;
        if (settings()->get('eval_visible', false)) {
            $evaluation[0] = EvaluationController::individualReport($class, $student);
        }

        $settings = EvaluationController::getEvalSettings($class->id);
        $settings['allow_upload'] = settings()->get('allow_upload', 0);
        $settings['allow_change_class'] = settings()->get('allow_change_class', 1);
        $settings['allow_send_money'] = settings()->get('allow_send_money', 0);
        $settings['transfer_fee'] = settings()->get('transfer_fee', 10);
        $settings['disable_your_adventure'] = settings()->get('disable_your_adventure', 0);
        $settings['impostor'] = settings()->get('impostor', -1);
        if($settings['impostor'] != -1) {
            if($settings['impostor'] == $student->id)
                $settings['impostor'] = true;
            else $settings['impostor'] = false;
        }

        $students_money = json_encode([]);
        if ($settings['allow_send_money']) {
            $students_money = $class->students()->pluck('classroom_user_id', 'name');
        }

        $chat['title'] = sha1(env('CHAT_KEY') . $class->id);
        $chat['url'] = env('APP_URL_SHORT');
        $chat['chatbro_id'] = env('CHATBRO_ID');
        $chat['id'] = auth()->user()->id . '-' . $student->id;
        $chat['name'] = $student->name;
        if (strpos($student->avatar, "http") !== false)
            $chat['avatar'] = $student->avatar;
        else $chat['avatar'] = env('APP_URL') . $student->avatar;

        $chat['signature'] = md5(env('APP_URL_SHORT') . $chat['id'] . $chat['name'] . $chat['avatar'] . env('CHATBRO_KEY'));
        $showChat = settings()->get('show_chat', false);

        $notifications = auth()->user()->unreadNotifications()->where('data->classroom', $code)->where('data->user', 'student')->get();

        return view('studentsview.show', compact('student', 'students_money', 'class', 'admin', 'shop', 'challenges', 'cards', 'evaluation', 'settings', 'chat', 'showChat', 'pets', 'notifications'));
    }

    public function rules($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $rules = Rules::where('classroom_id', $class->id)->first();
        $rules = Functions::replaceSpecial($rules->content, $class);
        $student = Functions::getCurrentStudent($class, []);

        return view('studentsview.rules', compact('class', 'rules', 'student'));
    }

    public function addRating()
    {
        $data = request()->validate([
            'rating' => ['numeric', 'required'],
            'challenge' => ['numeric', 'required'],
        ]);

        $challenge = Challenge::findOrFail($data['challenge']);

        $class = Classroom::where('id', $challenge->classroom())->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class, []);
        return $student->ratings()->sync([$challenge->id => ['rating' => $data['rating']]], false);
    }
    public function licenses($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class, []);

        return view('studentsview.licenses', compact('class', 'student'));
    }

    public function sendMoney($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('study', $class);
        $student = Functions::getCurrentStudent($class, []);

        $to = Student::where('classroom_user_id', '=', request()->to)->firstOrFail();
        if ($to->classroom->classroom_id != $class->id || request()->money > $student->gold || !settings()->get('allow_send_money', 0) || $to->id == $student->id)
            abort(403);;
        $fee = settings()->get('transfer_fee', 10);

        $gold = request()->money - request()->money * $fee / 100;
        $steal = 0;
        $thief = rand(0, 99);
        if ($thief >= 60) {
            $steal = ($gold * rand(0, 20) / 100);
            $gold = $gold - $steal;
        }

        $student->setProperty('gold', request()->money * -1, true, 'send', true);
        $to->setProperty('gold', $gold, true, 'received', true);

        $from['title'] = 'notifications.money_sent';
        $from['name'] = $student->name;
        $from['datetime'] = date_format(Carbon::now('Europe/Madrid'), 'd/m/Y H:i');

        $message = __('notifications.money_sent') . ' ' . request()->money . ' <i class="fas fa-coins colored"></i> ' . __('notifications.money_sent_taxes') . ($gold + $steal) . " <i class='fas fa-coins colored'></i> ";

        if ($steal) {
            $message .= __('notifications.money_sent_thief') . $steal . " <i class='fas fa-coins colored'></i> " . __('notifications.money_sent_total') . $gold . " <i class='fas fa-coins colored'></i>";
        }

        Notification::send($to->classroom->user, new NewInteractionStudent('notifications.money_sent', $message, $from, "money_sent", $class->code));

        return ['gold' => request()->money, 'received' => $gold, 'steal' => $steal];
    }

    public function markChallenge($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class, []);

        $data = request()->validate([
            'challenge' => ['numeric'],
        ]);
        $update = false;

        $challenge = Challenge::findOrFail($data['challenge']);
        $challengeStudent = $student->challenges->where('id', $challenge->id)->first();
        $update = false;
        if ($challenge->completion == 1) {
            if (!$challengeStudent) {
                $student->challenges()->attach($challenge->id);
                $update = true;
            }
        } else if ($challenge->completion == 2) {
            if ($student->challenges->where('id', $challenge->id)->first()->count == 2) {
                $update = true;
            }
        }
        if ($update) {
            $cards = [];
            if ($challenge->auto_assign == 1) {
                for ($i = 0; $i < $challenge->cards; $i++) {
                    array_push($cards, CardsController::getRandomCard($class->code));
                }
            }
            $student->assignChallenge($challenge, 1, $cards);
        }

        $from['title'] = $challenge->title;
        $from['name'] = $student->name;
        $from['username'] = $student->username;
        $from['datetime'] = date_format(Carbon::now('Europe/Madrid'), 'd/m/Y H:i');

        NotificationController::sendToTeachers(auth()->user()->id, $class->code, "notifications.mark_challenge", __("notifications.mark_challenge") . $from['title'], $from, "challenge", "challenges");

        return [
            'success' => true,
            'hp' => $student->hp,
            'xp' => $student->xp,
            'gold' => $student->gold,
            'challenges' => $this::getChallenges($student->fresh(), $class),
        ];
    }

    public function markCard($code, $id)
    {

        $data = request()->validate([
            'type' => ['numeric'],
            'student' => ['numeric', 'nullable'],
        ]);
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        if ($data['student']) {
            $student = Student::where('id', $data['student'])->firstOrFail();
            if ($student->classroom->classroom_id != $class->id)
                return false;
        } else
            $student = Functions::getCurrentStudent($class, []);

        $card = Card::where('id', '=', $id)->where('classroom_id', '=', $class->id)->first();
        $cardLine = CardStudent::where('card_id', $card->id)
            ->where('student_id', $student->id)
            ->orderBy('marked')
            ->first();

        $cardLine->update(['marked' => $data['type']]);

        $from['title'] = __("notifications.mark_card");
        $from['name'] = $student->name;
        $from['username'] = $student->username;
        $from['datetime'] = date_format(Carbon::now('Europe/Madrid'), 'd/m/Y H:i');

        NotificationController::sendToTeachers(auth()->user()->id, $class->code, "notifications.mark_card", __("notifications.mark_card_content"), $from, "mark_card", '');

        return [
            "message" => " " . __('success_error.update_success'),
            "icon" => "check",
            "type" => "success",
        ];
    }
    public function buyPet($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        $data = request()->validate([
            'pet' => ['numeric', 'required'],
        ]);

        $student = Functions::getCurrentStudent($class, []);

        if ($student->hp == 0)
            return false;

        $pet = Pet::where('id', $data['pet'])->where('classroom_id', $class->id)->where('for_sale', 1)->firstOrFail();

        if ($pet->price > $student->gold) {
            return [
                "message" => " " . __('success_error.shop_failed_money'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }

        $student->pets()->sync([$pet->id]);
        $student->update(['gold' => ($student->gold - $pet->price)]);

        return [
            "message" => " " . __('success_error.equipment_success'),
            "icon" => "check",
            "type" => "success",
            "pets" => $student->fresh()->pets,
            "boost" => $student->fresh()->getBoost(),
        ];
    }
    public function buyItem($code)
    {

        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);

        if (!settings()->get('items_visibility', false))
            abort(403);

        $student = Functions::getCurrentStudent($class, []);

        if ($student->hp == 0)
            return false;

        $data = request()->validate([
            'item' => 'numeric',
        ]);

        $item = Item::where('id', '=', $data['item'])->where('classroom_id', '=', $class->id)->where('for_sale', '=', '1')->firstOrFail();
        $studentItem = $student->items->where('id', $item->id)->first();

        if ($item->price > $student->gold) {
            return [
                "message" => " " . __('success_error.shop_failed_money'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }
        if ($student->level && $item->min_lvl > $student->level->number) {
            return [
                "message" => " " . __('success_error.shop_failed_level'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }

        if ($studentItem)
            $count = $studentItem->pivot->count + 1;
        else $count = 1;


        $student->items()->sync([$item->id => ['count' => $count]], false);
        $student->update(['gold' => ($student->gold - $item->price)]);
        LogEntry::create([
            'type' => 'gold',
            'value' => $item->price,
            'student_id' => $student->id,
            'message' => 'shop',
        ]);

        return [
            "message" => " " . __('success_error.equipment_success'),
            "icon" => "check",
            "type" => "success",
            "items" => $student->fresh()->items,
        ];
    }

    public function buyEquipment($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class, []);

        if ($student->hp == 0)
            abort(403);

        $new = Equipment::where('id', '=', request()->new)->firstOrFail();

        // $old = Equipment::where('id', '=', request()->old)->firstOrFail();
        $old = DB::table('equipment_student')
            ->join('equipment', 'equipment.id', 'equipment_student.equipment_id')
            ->where('equipment_student.student_id', '=', $student->id)
            ->where('equipment.type', '=', $new->type)
            ->select('*')
            ->first();

        // Avoid user mistakes
        if ($old->type != $new->type || $old->offset >= $new->offset || $new->character_id != $student->character_id || $student->equipment->contains($new->id)) {
            return [
                "message" => " " . __('success_error.shop_failed_exists'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        switch ($new->offset) {
            case 1:
            default:
                if (!settings()->get('equipment_1_visibility', false))
                    abort(403);
                $key = "shop_multiplier_1";
                break;
            case 2:
                if (!settings()->get('equipment_2_visibility', false))
                    abort(403);
                $key = "shop_multiplier_2";
                break;
            case 3:
                if (!settings()->get('equipment_3_visibility', false))
                    abort(403);
                $key = "shop_multiplier_3";
                break;
        }
        $mult = (float) settings()->get($key, 1);
        $price = round($new->price * $mult);
        if ($price > $student->gold) {
            return [
                "message" => " " . __('success_error.shop_failed_money'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }
        $gold = $student->gold - $price;
        $student->update(['gold' => $gold]);
        LogEntry::create([
            'type' => 'gold',
            'value' => $gold,
            'student_id' => $student->id,
            'message' => 'shop',
        ]);
        $student->equipment()->detach($old->id);
        $student->equipment()->attach($new->id);
        return [
            "message" => " " . __('success_error.equipment_success'),
            "icon" => "check",
            "type" => "success",
            "equipment" => $student->fresh()->equipment,
            "boost" => $student->fresh()->getBoost(),
        ];
    }

    public function useItem($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $data = request()->validate([
            'id' => 'numeric',
            'itemId' => 'numeric',
        ]);

        $student = Functions::getCurrentStudent($class, []);

        if ($student->hp <= 0)
            return false;

        $item = $student->items->where('id', '=', $data['itemId'])->first();

        if (!$item->pivot->count > 0)
            return false;

        if ($item->pivot->count == 1) {
            $student->items()->detach($item->id);
        } else
            $student->items()->updateExistingPivot($item->id, ['count' => $item->pivot->count - 1]);

        if ($item->hp > 0) {
            $student->setProperty('hp', $item->hp, true, 'item');
        }
        if ($item->xp > 0) {
            $student->setProperty('xp', $item->xp, true, 'item');
        }

        return ['xp' => $item->xp, 'hp' => $item->hp];
    }

    public function map($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $activeMap = settings()->get('active_map');

        $map = Map::where('id', '=', $activeMap)->firstOrFail();

        $student = Functions::getCurrentStudent($class);
        return view('studentsview.map', compact('class', 'map', 'student'));
    }
}
