<template>
  <div
    class="columns p-2 h-100 mr-0"
    v-bind:class="{ 'has-bg-student': !admin }"
  >
    <div class="column is-narrow pr-0 noprint" ref="studentInfo">
      <div
        class="card rounded card-shadow-s"
        style="min-width: 275px; overflow: visible"
      >
        <show-character
          ref="showStd"
          :student="student"
          :classroom="classroom"
        ></show-character>
        <div class="card-content">
          <div class="media mb-0 has-all-centered">
            <div class="media-left" v-if="classroom.character_theme">
              <figure class="image is-48x48">
                <img :src="student.avatar" class="rounded" alt />
              </figure>
            </div>
            <div class="media-content">
              <p class="title is-4">{{ student.name }}</p>
              <p class="subtitle is-6">
                <small>@{{ student.username }}</small>
              </p>
            </div>
          </div>

          <hp class="mt-2 mb-3" :hp="student.hp" :size="3"></hp>

          <div class="score p-3 m-1 mt-4 border">
            <span>
              <i class="fas fa-fist-raised colored"></i>
            </span>
            {{ student.xp }}
          </div>
          <div class="gold p-3 m-1 mt-2 border">
            <span>
              <i class="fas fa-coins colored"></i>
            </span>
            {{ student.gold }}
          </div>
          <div class="has-text-centered">
            <button
              @click="isSendMoneyActive = true"
              class="button is-warning m-1"
              v-if="student.gold && settings.allow_send_money == 1"
            >
              {{ trans.get("general.send") }}
              <i class="fas fa-coins colored"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="my-2 is-flex">
        <button class="button" @click="nextStudent(false)">
          <i class="fas fa-chevron-left mr-2"></i> {{ trans.get('pagination.previous') }}
        </button>
        <button class="button is-info left-auto" @click="nextStudent">
          {{ trans.get('pagination.next') }} <i class="fas fa-chevron-right ml-2"></i>
        </button>
      </div>
    </div>
    <div class="column pr-0">
      <b-tabs
        :destroy-on-hide="true"
        multiline
        v-model="activeTab"
        :key="update"
      >
        <b-tab-item
          :label="trans.get('students.settings')"
          icon="cog"
          icon-pack="fad"
        >
          <div class="p-2">
            <h3 class="title is-4 ml-2 mb-0">Avatar</h3>
            <div class="m-3" v-if="admin || settings.allow_upload != 0">
              <croppa
                v-model="image"
                :width="128"
                :height="128"
                accept="image/*"
                placeholder="📷 Avatar"
                :placeholder-font-size="16"
                canvas-color="transparent"
                :show-remove-button="true"
                remove-button-color="black"
                :show-loading="true"
                :loading-size="50"
                class="rounded"
              ></croppa>
            </div>
            <div class="m-3">
              <button
                class="button is-link"
                v-if="image && image.chosenFile"
                @click="updateAvatar()"
              >
                Update avatar
              </button>
            </div>
            <image-bank
              class="m-3"
              :admin="admin"
              :student="student"
              :code="classroom.code"
            ></image-bank>
          </div>
          <div class="field is-horizontal">
            <div class="field-label is-normal">
              <label class="label">{{ trans.get("students.name") }}</label>
            </div>
            <div class="field-body">
              <div class="field has-addons">
                <div class="control">
                  <input
                    class="input"
                    v-bind="{ disabled: !admin }"
                    v-bind:class="{ 'is-static': !admin }"
                    type="text"
                    v-model="student.name"
                  />
                </div>
                <div class="control" v-if="admin && student.name.length >= 3">
                  <a class="button is-info" @click="updateName">
                    <i class="fas fa-save"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="field is-horizontal" v-if="student.classroom.user.email">
            <div class="field-label is-normal">
              <label class="label">Email</label>
            </div>
            <div class="field-body">
              <div class="field">
                <p class="control">
                  <input
                    class="input is-static"
                    disabled
                    type="text"
                    v-model="student.classroom.user.email"
                  />
                </p>
              </div>
            </div>
          </div>
          <div class="field is-horizontal">
            <div class="field-label is-normal">
              <label class="label">Username</label>
            </div>
            <div class="field-body">
              <div class="field">
                <p class="control">
                  <input
                    class="input is-static"
                    disabled
                    type="text"
                    v-model="student.username"
                  />
                </p>
              </div>
            </div>
          </div>
          <div
            class="field is-horizontal"
            v-if="student.password_plain && admin"
          >
            <div class="field-label is-normal">
              <label class="label">{{ trans.get("students.password") }}</label>
            </div>
            <div class="field-body">
              <b-field class="is-static">
                <b-input
                  type="password"
                  style="width: 200px"
                  icon-pack="fas"
                  disabled
                  v-model="student.password_plain"
                  password-reveal
                ></b-input>
              </b-field>
            </div>
          </div>
          <div
            class="p-4"
            v-if="
              classroom.character_theme &&
              student.hp > 0 &&
              (admin || settings.allow_change_class == 1)
            "
          >
            <img
              v-tippy
              :content="
                trans.get('students.highlights') +
                ' <i class=\'' +
                charclass.property +
                ' colored\'></i>'
              "
              @click="confirmChangeClass(charclass.id)"
              v-bind:class="{ selected: charclass.id == student.character_id }"
              class="p-2 m-2 rounded"
              :src="'/img/character/characters/' + charclass.id + '.png'"
              v-for="charclass in classroom.character_theme.characters"
              v-bind:key="charclass.id"
            />
          </div>
          <div v-if="admin">
            <button
              class="button is-success"
              v-if="student.hidden == 1"
              @click="hide"
            >
              <i class="fas fa-eye"></i>
              {{ trans.get("students.show") }}
            </button>
            <button class="button is-warning" v-else @click="hide">
              <i class="fas fa-eye-slash"></i>
              {{ trans.get("students.hide") }}
            </button>
            <button class="button is-danger" @click="deleteStudent">
              <i class="fas fa-trash mr-2"></i>
              {{ trans.get("students.delete") }}
            </button>
          </div>
        </b-tab-item>

        <b-tab-item
          :label="trans.get('students.inventory')"
          class="p-2 pt-4"
          icon="backpack"
          icon-pack="fad"
        >
          <!-- <div  class="notification is-light cursor-default mb-3 mt-0">
          </div> -->

          <article
            class="message is-dark mb-3"
            v-tippy
            :content="trans.get('students.last')"
            v-if="!admin && student.behaviours.length"
          >
            <div class="message-body">
              <span v-html="lastBehaviour()"></span>
            </div>
          </article>

          <div
            class="mb-3 mt-0"
            v-if="!admin && student.numcards[0] > student.numcards[1]"
          >
            <article class="message is-danger">
              <div class="message-body">
                <i class="fas fa-exclamation-square"></i>
                {{ trans.get("success_error.cards_exceded") }}
                {{ student.numcards[0] }} /
                {{ student.numcards[1] }}
              </div>
            </article>
          </div>

          <div class="columns is-multiline is-variable" v-if="admin">
            <div
              v-for="item in items"
              class="column py-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd"
              v-bind:key="item.id"
            >
              <b-field>
                <p class="control">
                  <img :src="item.icon" />
                </p>
                <b-numberinput
                  @input="updateInventory(item.id, item.count)"
                  min="0"
                  icon-pack="fa"
                  v-model="item.count"
                  expanded
                  controlsPosition="compact"
                />
              </b-field>
            </div>
          </div>
          <div class="inventory" id="inventory" v-if="!admin">
            <div>
              <div
                v-for="item in student.items"
                v-tippy
                :content="message(item)"
                v-show="item.pivot.count > 0"
                class="inventory-item"
                v-bind:key="item.id"
              >
                <img
                  :src="item.icon"
                  @click="item.hp > 0 ? useItem(item, message(item)) : null"
                  class="item"
                />
                <div class="number-items">{{ item.pivot.count }}</div>
              </div>
            </div>
            <div>
              <div
                v-for="index in inventoryRemaining"
                class="inventory-item"
                v-bind:key="index"
              ></div>
            </div>
            <div v-if="classroom.character_theme" :key="forceReload">
              <div
                v-for="gear in orderedEquipment"
                v-bind:key="gear.id"
                v-tippy
                :content="propertiesMessage(gear)"
                :ref="'item' + gear.id"
                class="inventory-item inv-item-armor relative"
                v-bind:class="{
                  'inv-item-armor-bronce': gear.offset == 1,
                  'inv-item-armor-silver': gear.offset == 2,
                  'inv-item-armor-gold': gear.offset == 3,
                }"
              >
                <img
                  :src="'/img/character/' + gear.src"
                  :alt="gear.id"
                  class="item"
                />
                <div
                  class="price-buy rounded not-hover"
                  v-if="
                    (eq1Json || eq2Json || eq3Json) &&
                    gear.id != 41 &&
                    gear.id != 50
                  "
                >
                  <i class="fas fa-plus"></i>
                </div>
                <div
                  class="w-100 shop-sub-item"
                  style="position: absolute; top: 100px; left: 0"
                >
                  <div
                    v-for="(i, index) in [eq1Json, eq2Json, eq3Json]"
                    :key="index"
                  >
                    <div
                      v-for="itemStore in filterEquipment(i, gear.type)"
                      v-bind:key="itemStore.id"
                      class="inventory-item inv-item-armor w-100"
                      v-bind:class="{
                        'inv-item-armor-bronce': index == 0,
                        'inv-item-armor-silver': index == 1,
                        'inv-item-armor-gold': index == 2,
                      }"
                    >
                      <img
                        v-tippy
                        :content="propertiesMessage(itemStore)"
                        :src="'/img/character/' + itemStore.src"
                        :alt="itemStore.id"
                        class="item"
                      />
                      <div
                        class="price-buy rounded"
                        @click="buyEquipment(gear, itemStore)"
                      >
                        {{ calculate(itemStore) }}
                        <i class="fas fa-coins colored"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class style="clear: both"></div>
          </div>
          <div class="shop pt-3" v-if="itemsJson">
            <h2 class="is-size-2"><i class="fas fa-store"></i> Shop</h2>
            <div
              class="columns p-4 m-2 rounded"
              v-for="item in itemsJson"
              :key="item.id"
            >
              <div
                class="column is-relative is-flex has-all-centered is-narrow"
              >
                <div class="lvl-item-top-left" v-if="item.min_lvl">
                  <img src="/img/cardgen/lvl.png" class="levelCard" />
                  <span class="is-flex has-all-centered">{{
                    item.min_lvl
                  }}</span>
                </div>
                <img :src="item.icon" />
              </div>
              <div
                class="column is-flex has-all-centered rounded wheat"
                v-html="message(item)"
              ></div>
              <div class="column is-flex has-all-centered is-narrow item-price">
                <button class="button is-success" @click="buyItem(item)">
                  {{ trans.get("shop.buy") }} {{ item.price }}
                  <i class="fas fa-coins colored" style="z-index: 0"></i>
                </button>
              </div>
            </div>
          </div>
        </b-tab-item>
        <b-tab-item
          :label="trans.get('menu.adventure')"
          icon="feather-alt"
          v-if="settings.disable_your_adventure == 0"
          icon-pack="fad"
          class="p-2"
        >
          <Blogs
            :code="classroom.code"
            :student="student"
            :admin="admin"
            :blogs="student.blogs"
          ></Blogs>
        </b-tab-item>
        <b-tab-item
          :label="trans.get('menu.pets')"
          v-if="
            (pets && pets.length) || (classroom.pets && classroom.pets.length)
          "
          icon="dog"
          icon-pack="fad"
          class="p-2"
        >
          <article class="message is-danger">
            <div class="message-body">
              <i class="fas fa-exclamation-triangle"></i>
              {{ trans.get("shop.pet_warning") }}
            </div>
          </article>
          <div v-if="!admin">
            <div v-for="pet in pets" :key="pet.id" class="p-2 m-2">
              <div class="columns mb-0">
                <div class="column is-narrow">
                  <img
                    v-tippy="{
                      theme: 'light bordered',
                      placement: 'bottom',
                      arrow: true,
                    }"
                    width="81px"
                    :content="getName(pet.name)"
                    :src="pet.image"
                    class="pet-selector"
                  />
                </div>
                <div class="column">
                  <span class="p-2"
                    >{{ pet.hp_boost }}% <i class="fas fa-heart colored"></i
                  ></span>
                  <span class="ml-3 p-2"
                    >{{ pet.xp_boost }}%
                    <i class="fas fa-fist-raised colored"></i
                  ></span>
                  <span class="ml-3 p-2"
                    >{{ pet.gold_boost }}% <i class="fas fa-coins colored"></i
                  ></span>
                </div>
                <div class="column is-narrow">
                  <button class="button is-success" @click="buyPet(pet)">
                    {{ trans.get("shop.buy") }} {{ pet.price }}
                    <i class="fas fa-coins colored" style="z-index: 0"></i>
                  </button>
                </div>
              </div>
              <hr class="mt-0" />
            </div>
          </div>
          <div v-else>
            <div v-for="pet in classroom.pets" :key="pet.id" class="p-2 m-2">
              <div class="columns mb-0">
                <div class="column is-narrow">
                  <img
                    v-tippy="{
                      theme: 'light bordered',
                      placement: 'bottom',
                      arrow: true,
                    }"
                    :content="getName(pet.name)"
                    :src="pet.image"
                    width="81px"
                    class="pet-selector"
                  />
                </div>
                <div class="column">
                  <span class="p-2"
                    >{{ pet.hp_boost }}% <i class="fas fa-heart colored"></i
                  ></span>
                  <span class="ml-3 p-2"
                    >{{ pet.xp_boost }}%
                    <i class="fas fa-fist-raised colored"></i
                  ></span>
                  <span class="ml-3 p-2"
                    >{{ pet.gold_boost }}% <i class="fas fa-coins colored"></i
                  ></span>
                </div>
                <div class="column is-narrow">
                  <button class="button is-success" @click="assign(pet)">
                    {{ trans.get("general.assign") }}
                  </button>
                </div>
              </div>
              <hr class="mt-0" />
            </div>
          </div>
        </b-tab-item>
        <b-tab-item
          v-if="admin || cards.length"
        >
        <template slot="header">
            <b-icon pack="fad" icon="club" />
            {{ trans.get("students.cards") }}
            <span class="tag is-link tag-notif" :class="{'is-danger' : student.numcards[0] > student.numcards[1] }" style="left: 2px">{{ student.numcards[0] }} / {{ student.numcards[1] }}</span>
          </template>
          <button
            class="button is-link ml-3 mt-1"
            v-if="admin"
            @click="isAssignModalActive = true"
          >
            {{ trans.get("cards.assign") }}
          </button>
          <div class="columns is-multiline is-variable">
            <div
              v-for="(card, index) in cards"
              :key="index"
              class="column is-6-tablet is-12-mobile is-6-desktop is-4-fullhd"
            >
              <show-card
                class="m-4"
                :student="student"
                :card="card"
                :code="classroom.code"
                :use="true"
                :admin="admin"
                :properties="false"
              ></show-card>
            </div>
          </div>
        </b-tab-item>
        <b-tab-item
          :label="trans.get('students.behaviours')"
          v-if="behaviours && behaviours.length"
          icon="heart"
          icon-pack="fad"
          class="p-2"
        >
          <div class="is-flex justify-content-center">
            <apexchart
              v-if="series.length"
              width="450"
              type="donut"
              :options="{
                labels: labels,
                colors: colors,
              }"
              :series="series"
            ></apexchart>
          </div>

          <div class="columns">
            <div class="column">
              <input type="date" class="input is-rounded" v-model="dateStart" />
            </div>
            <div class="column">
              <input type="date" class="input is-rounded" v-model="dateEnd" />
            </div>
          </div>

          <b-table
            v-if="behaviours && behaviours.length"
            :data="filteredEntries"
            default-sort-direction="asc"
            default-sort="created_at"
            icon-pack="fas"
            sort-icon="arrow-up"
          >
            <template slot-scope="props">
              <b-table-column
                field="icon"
                :label="trans.get('students.icon')"
                centered
              >
                <span
                  class="tag is-light"
                  v-bind:class="[
                    props.row.xp + props.row.hp + props.row.gold >= 0
                      ? 'is-success'
                      : 'is-danger',
                  ]"
                >
                  <i :class="props.row.icon"></i>
                </span>
              </b-table-column>

              <b-table-column
                field="name"
                :label="trans.get('students.name')"
                centered
                sortable
                >{{ trans.get(props.row.name) }}</b-table-column
              >

              <b-table-column
                field="created_at"
                :custom-sort="sortByDate"
                :label="trans.get('students.created_at')"
                sortable
                centered
                >{{
                  new Date(props.row.pivot.created_at).toLocaleDateString()
                }}</b-table-column
              >

              <b-table-column
                field="hp"
                :label="trans.get('students.hp')"
                centered
                sortable
              >
                <i class="fas fa-heart"></i>
                {{ props.row.hp }}
              </b-table-column>

              <b-table-column
                field="name"
                :label="trans.get('students.xp')"
                sortable
                centered
              >
                <i class="fas fa-fist-raised"></i>
                {{ props.row.xp }}
              </b-table-column>

              <b-table-column
                field="name"
                :label="trans.get('students.gold')"
                sortable
                centered
              >
                <i class="fas fa-coins"></i>
                {{ props.row.gold }}
              </b-table-column>

              <b-table-column
                field="name"
                :label="trans.get('students.settings')"
                v-if="admin"
                centered
              >
                <b-button
                  type="is-danger is-small"
                  @click="
                    confirmDelete(
                      'behaviour',
                      props.row,
                      props.row.pivot.created_at
                    )
                  "
                >
                  <i class="fas fa-trash-alt"></i>
                </b-button>
              </b-table-column>
            </template>
          </b-table>
        </b-tab-item>

        <b-tab-item
          :label="trans.get('students.challenges')"
          v-if="challenges && challenges.length"
          icon="pen-fancy"
          icon-pack="fad"
          class="p-2"
        >
          <div v-for="challenge in orderedChallenges" :key="challenge.id">
            <show-challenge
              :challenge="challenge"
              :code="classroom.code"
              :admin="admin"
              :edit="false"
            ></show-challenge>
          </div>
        </b-tab-item>

        <b-tab-item
          :label="trans.get('students.evaluation')"
          v-if="evaluation"
          class="p-2"
          icon="analytics"
          icon-pack="fad"
        >
          <report
            :classroom="classroom"
            :admin="admin"
            :grades="evaluation"
            :settings="settings"
          ></report>
          <div class="content">
            <table class="grades has-background-light">
              <th>{{ trans.get("evaluation.description") }}</th>
              <th>{{ trans.get("evaluation.grade_number") }}</th>
              <th>{{ trans.get("evaluation.tags") }}</th>
              <th>{{ trans.get("evaluation.feedback") }}</th>
              <tr v-for="(grade, index) in student.grades" :key="index">
                <td>{{ grade.description }}</td>
                <td>
                  <span
                    v-if="
                      admin ||
                      (settings.eval_type != 1 && settings.eval_type != 2)
                    "
                  >
                    <span
                      v-if="grade.rubric_id"
                      class="cursor-pointer"
                      @click="loadRubric(grade.rubric_id)"
                    >
                      <span
                        class="tag is-size-6"
                        :class="{
                          'is-success':
                            grade.pivot.grade >= settings.eval_max / 2,
                          'is-danger':
                            grade.pivot.grade < settings.eval_max / 2,
                        }"
                        ><i class="fas fa-external-link-alt mr-2"></i>
                        {{ grade.pivot.grade }}</span
                      >
                    </span>

                    <span
                      v-else
                      class="tag is-size-6"
                      :class="{
                        'is-success':
                          grade.pivot.grade >= settings.eval_max / 2,
                        'is-danger': grade.pivot.grade < settings.eval_max / 2,
                      }"
                      >{{ grade.pivot.grade }}</span
                    >
                  </span>

                  <span v-if="settings.eval_type == 1">
                    <i
                      :class="
                        'fas ' + getEmoji(grade.pivot.grade) + ' rateEmoji'
                      "
                    ></i>
                  </span>
                  <span
                    v-if="settings.eval_type == 2"
                    class="tag"
                    :class="{
                      'is-success': grade.pivot.grade >= settings.eval_max / 2,
                      'is-danger': grade.pivot.grade < settings.eval_max / 2,
                    }"
                  >
                    <i :class="'fas ' + getPassFail(grade.pivot.grade)"></i>
                  </span>
                </td>
                <td>
                  <span
                    v-for="(tag, index) in grade.tags"
                    class="tag is-dark cursor-default mx-1"
                    v-tippy
                    :content="
                      tag.description +
                      ' (' +
                      trans.get('evaluation.weight') +
                      ': ' +
                      tag.pivot.weight +
                      ')'
                    "
                    :key="index"
                    >{{ tag.short }}</span
                  >
                </td>
                <td>{{ grade.pivot.feedback }}</td>
              </tr>
            </table>
          </div>
        </b-tab-item>

        <b-tab-item
          v-if="
            (classroom.badges && classroom.badges.length) ||
            student.badges.length
          "
          icon="award"
          icon-pack="fad"
          class="p-2"
        >
          <template slot="header">
            <b-icon pack="fad" icon="award" />
            {{ trans.get("students.badges") }}
            <span class="tag is-link tag-notif" style="left: 2px">{{ student.badges.length }}</span>
          </template>
          <div v-if="admin" class="is-flex pl-4">
            <div class="mx-2" v-for="badge in classroom.badges" :key="badge.id">
              <ShowBadge
                :student="student"
                :badge="badge"
                :admin="true"
              ></ShowBadge>
            </div>
            <div class="mx-2" v-for="badge in student.badges" :key="badge.id">
              <ShowBadge
                v-if="!badge.classroom_id"
                :student="student"
                :badge="badge"
                :admin="false"
              ></ShowBadge>
            </div>
          </div>
          <div class="is-flex pl-4" v-if="!admin">
            <div class="mx-2" v-for="badge in student.badges" :key="badge.id">
              <ShowBadge
                :student="student"
                :badge="badge"
                :admin="false"
              ></ShowBadge>
            </div>
          </div>
        </b-tab-item>

        <b-tab-item
          :label="trans.get('students.log')"
          v-if="student.log_entries.length"
          icon="file"
          icon-pack="fad"
          class="p-2"
        >
          <div class="columns">
            <div class="column">
              <input type="date" class="input is-rounded" v-model="dateStart" />
            </div>
            <div class="column">
              <input type="date" class="input is-rounded" v-model="dateEnd" />
            </div>
          </div>
          <b-table
            v-if="student.log_entries.length"
            :data="filteredLogEntries"
            default-sort-direction="asc"
            default-sort="created_at"
            icon-pack="fas"
            sort-icon="arrow-up"
          >
            <template slot-scope="props">
              <b-table-column
                field="type"
                :label="trans.get('students.type')"
                centered
              >
                <span
                  class="tag is-light"
                  v-bind:class="[
                    props.row.value >= 0 ? 'is-success' : 'is-danger',
                  ]"
                >
                  <span v-if="props.row.type == 'xp'"
                    ><i class="fas fa-fist-raised colored"></i
                  ></span>
                  <span v-if="props.row.type == 'gold'"
                    ><i class="fas fa-coins colored"></i
                  ></span>
                  <span v-if="props.row.type == 'hp'"
                    ><i class="fas fa-heart colored"></i
                  ></span>
                </span>
              </b-table-column>

              <b-table-column
                field="value"
                :label="trans.get('students.value')"
                sortable
                >{{ props.row.value }}</b-table-column
              >

              <b-table-column
                field="created_at"
                :custom-sort="sortByLogDate"
                :label="trans.get('students.created_at')"
                sortable
                centered
                >{{
                  new Date(props.row.created_at).toLocaleDateString()
                }}</b-table-column
              >

              <b-table-column
                field="message"
                :label="trans.get('students.details')"
                centered
              >
                <span
                  v-tippy
                  :content="trans.get('students.log_' + props.row.message)"
                  v-html="getIcon(props.row.message)"
                >
                </span>
              </b-table-column>

              <b-table-column
                field="name"
                :label="trans.get('students.settings')"
                v-if="admin"
                centered
              >
                <b-button
                  type="is-danger is-small"
                  @click="
                    confirmDelete('logentry', props.row, props.row.created_at)
                  "
                >
                  <i class="fas fa-trash-alt"></i>
                </b-button>
              </b-table-column>
            </template>
          </b-table>
        </b-tab-item>
      </b-tabs>
    </div>

    <b-modal
      v-if="admin"
      :active.sync="isAssignModalActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get("cards.assign") }}</p>
        </header>
        <section class="modal-card-body is-relative" style="z-index: 1">
          <show-cards
            :code="classroom.code"
            :cards="allcards"
            :student="student.id"
          ></show-cards>
        </section>
        <footer
          class="modal-card-foot columns is-multiline"
          style="overflow-x: auto"
        >
          <div class="column is-narrow">
            <button class="button" type="button" @click="reload">
              {{ trans.get("general.close") }}
            </button>
          </div>
        </footer>
      </div>
    </b-modal>

    <b-modal
      :active.sync="showRubric"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
      full-screen
      v-if="rubric"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ student.name }}</p>
        </header>
        <section class="modal-card-body">
          <div
            class="div_rounded rubricRow marginRadius"
            v-for="rubricRow in rubric.rows"
            :key="rubricRow.id"
          >
            <h2 class="description">{{ rubricRow.description }}</h2>
            <div class="rubricSubitems">
              <div
                class="rubricSubitem marginRadius"
                v-for="item in rubricRow.items"
                :key="item.id"
                :row="'row' + rubricRow.id"
                :item="'item' + item.id"
              >
                <div class="rubricDetails">{{ item.description }}</div>
                <div class="rubricScore">{{ item.points }}</div>
              </div>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="showRubric = false">
            {{ trans.get("general.close") }}
          </button>
        </footer>
      </div>
    </b-modal>

    <b-modal
      :active.sync="isSendMoneyActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">
            {{ trans.get("students.send_money") }}
          </p>
        </header>
        <section class="modal-card-body">
          <div class="py-3">
            <b-field :label="trans.get('auth.student')">
              <b-select
                v-model="send_money_student"
                expanded
                placeholder="Select a name"
              >
                <option
                  :value="id"
                  v-for="(id, name) in students_money"
                  :key="id"
                >
                  {{ name }}
                </option>
              </b-select>
            </b-field>
            <b-field>
              <template slot="label">
                <i class="fas fa-coins colored"></i>
              </template>
              <b-numberinput
                :max="student.gold"
                :min="50"
                expanded
                v-model="send_money"
                controls-position="compact"
              ></b-numberinput>
            </b-field>
            <article class="message is-warning">
              <div class="message-body">
                {{ trans.get("students.transfer_fee") }}
                {{ settings.transfer_fee }}%. {{ trans.get("students.thief") }}
              </div>
            </article>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button
            class="button"
            type="button"
            @click="isSendMoneyActive = false"
          >
            {{ trans.get("general.close") }}
          </button>
          <button
            @click.prevent="sendMoney"
            :disabled="send_money < 50 || !send_money_student"
            class="button is-primary"
          >
            {{ trans.get("general.send") }}
          </button>
        </footer>
      </div>
    </b-modal>
    <b-modal
      :active.sync="moneySended"
      has-modal-card
      trap-focus
      :destroy-on-hide="true"
      aria-role="dialog"
      aria-modal
    >
      <div class="card">
        <div class="card-content" v-if="transaction">
          <div class="fs-2">
            <i class="fas fa-coins colored"></i>
            <i class="fas fa-arrow-right colored"></i>
            <i class="fas fa-user colored"></i>
          </div>
          <div class="fs-2">
            <div class="my-2 py-2">
              {{ trans.get("students.money_sent") }}: {{ transaction.gold }}
              <i class="fas fa-coins colored"></i>
            </div>

            <div class="my-2 py-2">
              {{ trans.get("students.comission") }}:
              {{
                Math.round(
                  transaction.gold - transaction.received - transaction.steal
                )
              }}
              <i class="fas fa-coins colored"></i>
            </div>
            <div class="my-2 py-2" v-if="transaction.steal != 0">
              <i class="fas fa-hood-cloak colored"></i>
              {{ trans.get("students.thief_info") }} {{ transaction.steal }}
              <i class="fas fa-coins colored"></i>
            </div>
            <div class="my-2 py-2">
              {{ trans.get("students.money_received") }}:
              {{ transaction.received }} <i class="fas fa-coins colored"></i>
            </div>
          </div>
        </div>
      </div>
    </b-modal>
  </div>
</template>

<script>
import Vue from "vue";

import Utils from "../../utils.js";

import ShowBadge from "../badge/ShowBadge.vue";

import Blogs from "../blogs/Blogs.vue";
import Hp from "./Hp.vue";

// Charts
import VueApexCharts from "vue-apexcharts";
Vue.use(VueApexCharts);
Vue.component("apexchart", VueApexCharts);

export default {
  props: [
    "student",
    "classroom",
    "chart",
    "admin",
    "items",
    "shop",
    "challenges",
    "cards",
    "evaluation",
    "settings",
    "allcards",
    "pets",
    "students_money",
  ],
  components: {
    Blogs,
    Hp,
    ShowBadge,
  },
  mounted() {
    this.behaviours = this.student.behaviours;
    if (!this.admin) {
      this.activeTab = 1;

      this.updateEmpty();

      this.itemsJson = JSON.parse(this.shop.items);
      this.eq1Json = JSON.parse(this.shop.eq1);
      this.eq2Json = JSON.parse(this.shop.eq2);
      this.eq3Json = JSON.parse(this.shop.eq3);
    }
  },
  data: function () {
    return {
      activeTab: 0,
      dateStart: null,
      dateEnd: null,
      series: [],
      labels: [],
      colors: [],
      update: 0,
      inventoryRemaining: 0,
      itemsJson: null,
      eq1Json: null,
      eq2Json: null,
      eq3Json: null,
      forceReload: 0,
      isSendMoneyActive: false,
      prevImage: null,
      image: null,
      behaviours: null,
      isAssignModalActive: false,
      showRubric: false,
      rubric: null,
      send_money: 50,
      send_money_student: null,
      moneySended: false,
      transaction: null,
    };
  },
  methods: {
    nextStudent(next = true) {
      const currentStudent = (element) => element.id == this.student.id;
      let nextId;
      let index;
      if(next) {
        index = (this.classroom.students.findIndex(currentStudent) + 1) % this.classroom.students.length;
      } else {
        index = (this.classroom.students.findIndex(currentStudent) - 1) % this.classroom.students.length;  
        if(index == -1)
          index = this.classroom.students.length - 1;
      }
      console.log(index);
      nextId = this.classroom.students[index].id;
      
      location.href = '/classroom/' + this.classroom.code + '/student/' + nextId;
      
    },
    getIcon(type) {
      switch (type) {
        case "behaviour":
          return "<i class='fas fa-heart colored'></i>";
          break;
        case "teacher":
          return "<i class='fas fa-user-graduate colored' style='color: white'></i>";
          break;
        case "shop":
          return "<i class='fas fa-store colored' style='color: #A52A2A'></i>";
          break;
        case "item":
          return "<i class='fas fa-flask-potion colored' style='color: #DC143C'></i>";
          break;
        case "event":
          return "<i class='fas fa-scroll colored' style='color: #A9A9A9'></i>";
          break;
        case "send":
          return "<i class='fas fa-coins colored'></i><i class='fas fa-arrow-right colored'></i>";
          break;
        case "received":
          return "<i class='fas fa-coins colored'></i><i class='fas fa-arrow-left colored'></i>";
          break;
        case "challenge":
          return "<i class='fas fa-pen-fancy colored' style='color: #eee'></i>";
          break;
        case "card":
          return "<i class='fas fa-club colored' style='color: black'></i>";
          break;
        case "badge":
          return "<i class='fas fa-award colored' style='color: #ADD8E6'></i>";
          break;
        case "battle":
          return "<i class='fas fa-swords colored' style='color: #E6E6FA'></i>";
          break;
        case "wheel":
          return "<i class='fas fa-spinner colored' style='color: #E6E6FA'></i>";
          break;
      }
    },
    sendMoney() {
      axios
        .post("/classroom/" + this.classroom.code + "/send/money", {
          money: this.send_money,
          to: this.send_money_student,
        })
        .then((response) => {
          this.student.gold -= this.send_money;
          this.transaction = response.data;
          this.isSendMoneyActive = false;
          this.moneySended = true;
        })
        .catch((error) => {
          this.$toast(this.trans.get("students.error"), { type: "error" });
        });
    },
    lastBehaviour: function () {
      let behaviour = this.student.behaviours[
        this.student.behaviours.length - 1
      ];
      let text;
      if (behaviour.custom_text == null) text = behaviour.name;
      else text = behaviour.custom_text;
      if (behaviour)
        return (
          "<span class='tag is-dark'>" +
          new Date(behaviour.created_at).toLocaleDateString() +
          "</span>" +
          "<i class='" +
          behaviour.icon +
          " mx-2'></i>" +
          this.trans.get(text)
        );
      return "";
    },
    getPassFail: function (grade) {
      return Utils.getPassFail(grade, this.settings.eval_max);
    },
    getEmoji: function (grade) {
      return Utils.getEmoji(grade, this.settings.eval_max);
    },
    loadRubric: function (rubric) {
      axios
        .post("/classroom/evaluation/rubric", {
          rubric: rubric,
        })
        .then((response) => {
          this.rubric = response.data;
          this.showRubric = true;

          axios
            .post("/classroom/evaluation/student/rubric", {
              student: this.student.id,
              rubric: rubric,
            })
            .then((response) => {
              response.data.forEach((row) => {
                document
                  .querySelector(
                    "[row=row" + row[0] + "][item=item" + row[1] + "]"
                  )
                  .classList.add("selectedSubItem");
              });
            });
        });
    },
    calculate(item) {
      let mult = 1;
      switch (item.offset) {
        case 1:
          mult = this.shop.multiplier1;
          break;
        case 2:
          mult = this.shop.multiplier2;
          break;
        case 3:
          mult = this.shop.multiplier3;
          break;
      }
      return Math.round(item.price * mult);
    },
    hide() {
      axios
        .post("/classroom/students/toggle", {
          id: this.student.id,
          prop: "hidden",
        })
        .then((response) => {
          this.student.hidden = (this.student.hidden + 1) % 2;
          this.$forceUpdate();
        });
    },
    deleteStudent() {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          axios
            .delete(
              "/classroom/" +
                this.classroom.code +
                "/student/" +
                this.student.id,
              {
                _method: "delete",
              }
            )
            .then((response) => {
              location.href = "/classroom/" + this.classroom.code;
            });
        },
      });
    },
    updateName() {
      if (this.student.name.length >= 4) {
        axios
          .post("/classroom/" + this.classroom.code + "/student/name", {
            id: this.student.id,
            name: this.student.name,
          })
          .then((response) => {
            this.$toast(this.trans.get("success_error.update_success"), {
              type: "success",
            });

            this.$forceUpdate();
          });
      } else {
        this.$toast(this.trans.get("success_error.min_name"), {
          type: "error",
        });
      }
    },
    confirmDelete(type, row, date) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          axios
            .post("/classroom/student/" + type, {
              row: row,
              date: date,
              student: this.student.id,
              _method: "delete",
            })
            .then((response) => {
              if (type == "behaviour") {
                this.behaviours = response.data;
                this.student.updated_at = new Date();
                this.forceRerender();
              } else {
                location.reload();
              }
            });
        },
      });
    },
    updateEmpty() {
      let line = 6;
      if (this.student.items.length >= 6) {
        line = 12;
      }
      this.inventoryRemaining = line - this.student.items.length;
    },
    confirmChangeClass(subclass) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("students.change_class"),
        message: this.trans.get("students.basic_equipment"),
        confirmText: this.trans.get("students.change_class"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-warning",
        iconPack: "fa",
        hasIcon: true,
        onConfirm: () => {
          axios
            .post(
              "/classroom/" + this.classroom.code + "/student/changecharacter",
              { id: this.student.id, character_id: subclass, mode: "student" }
            )
            .then((response) => {
              location.reload();
            });
        },
      });
    },
    useItem(item, messageItem) {
      this.$buefy.dialog.confirm({
        message: messageItem + " <br><br>Would you like to use the item?",
        onConfirm: () => {
          axios
            .post("/classroom/" + this.classroom.code + "/student/useitem", {
              id: this.student.id,
              itemId: item.id,
            })
            .then((response) => {
              if (!response.data) {
              } else {
                item.pivot.count--;
                if (item.pivot.count == 0) this.inventoryRemaining++;
                this.student.hp = Math.min(
                  this.student.hp + response.data.hp,
                  100
                );
                this.student.xp += response.data.xp;
                this.forceRerender();
              }
            });
        },
      });
    },
    reload() {
      location.reload();
    },
    forceRerender() {
      this.update += 1;
    },
    updateInventory(item, count) {
      axios.patch("/classroom/student/inventory", {
        id: this.student.id,
        item_id: item,
        count: count,
        _method: "patch",
      });
    },
    message(item) {
      let message = "";
      if (item.hp > 0)
        message +=
          this.trans.get("shop.recovers_hp") +
          item.hp +
          " <i class='fas fa-heart colored'></i>. ";
      if (item.xp > 0)
        message +=
          this.trans.get("shop.gives_xp") +
          item.xp +
          " <i class='fas fa-fist-raised colored'></i>. ";
      if (message == "" && !item.description)
        return this.trans.get("shop.what_is");
      message += item.description ? item.description : "";
      return message;
    },
    propertiesMessage(itemStore) {
      return (
        itemStore.hp +
        "% <i class='fas fa-heart colored'></i> " +
        itemStore.xp +
        "% <i class='fas fa-fist-raised colored'></i> " +
        itemStore.gold +
        "% <i class='fas fa-coins colored'></i>"
      );
    },
    sortByDate(a, b) {
      return (
        new Date(b.pivot.created_at).getTime() -
        new Date(a.pivot.created_at).getTime()
      );
    },
    sortByLogDate(a, b) {
      return (
        new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
      );
    },
    getName(name) {
      if (name) return name + " 🍅🍖";
      else return "🍅🍖";
    },
    assign(pet) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.assign"),
        message: this.trans.get("shop.assign_text"),
        confirmText: this.trans.get("general.assign"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-link",
        iconPack: "fa",
        hasIcon: false,
        onConfirm: () => {
          axios
            .post("/classroom/" + this.classroom.code + "/student/assignpet", {
              pet: pet.id,
              student: this.student.id,
            })
            .then((response) => {
              this.$toast(response.data.message, { type: response.data.type });

              if (response.data.type == "success") {
                this.student.pets = response.data.pets;
                this.student.boost = response.data.boost;
                this.$forceUpdate();
                this.$refs.showStd.$forceUpdate();
              }
            });
        },
      });
    },
    buyPet(pet) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("shop.buy_item"),
        message: this.trans.get("shop.buy_text") + "?",
        confirmText: this.trans.get("shop.buy"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-link",
        iconPack: "fa",
        hasIcon: false,
        onConfirm: () => {
          axios
            .post("/classroom/" + this.classroom.code + "/student/buypet", {
              pet: pet.id,
            })
            .then((response) => {
              this.$toast(response.data.message, { type: response.data.type });

              if (response.data.type == "success") {
                this.student.pets = response.data.pets;
                this.student.gold = this.student.gold - pet.price;
                this.student.boost = response.data.boost;
                this.$forceUpdate();
                this.$refs.showStd.$forceUpdate();
              }
            });
        },
      });
    },
    buyItem(item) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("shop.buy_item"),
        message: this.trans.get("shop.buy_text") + "?",
        confirmText: this.trans.get("shop.buy"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-link",
        iconPack: "fa",
        hasIcon: false,
        onConfirm: () => {
          axios
            .post("/classroom/" + this.classroom.code + "/student/buyitem", {
              item: item.id,
            })
            .then((response) => {
              this.$toast(response.data.message, { type: response.data.type });

              if (response.data.type == "success") {
                this.student.items = response.data.items;
                this.updateEmpty();
                this.student.gold = this.student.gold - item.price;
                this.$forceUpdate();
              }
            });
        },
      });
    },
    buyEquipment(oldItem, newItem) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("shop.buy_item"),
        message:
          this.trans.get("shop.buy_text") +
          newItem.price +
          "<i class='fas fa-coins colored'></i>? (" +
          newItem.hp +
          "% <i class='fas fa-heart colored'></i> | " +
          newItem.xp +
          "% <i class='fas fa-fist-raised colored'></i> | " +
          newItem.gold +
          "% <i class='fas fa-coins colored'></i>)",
        confirmText: this.trans.get("shop.buy"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-link",
        iconPack: "fa",
        hasIcon: false,
        onConfirm: () => {
          axios
            .post(
              "/classroom/" + this.classroom.code + "/student/buyequipment",
              {
                new: newItem,
              }
            )
            .then((response) => {
              this.$toast(response.data.message, { type: response.data.type });

              if (response.data.type == "success") {
                this.student.equipment = response.data.equipment;
                this.student.gold = this.student.gold - this.calculate(newItem);
                oldItem.src = newItem.src;
                let reference = "item" + oldItem.id;
                this.student.boost = response.data.boost;
                let newClass = "inv-item-armor-bronce";
                switch (newItem.offset) {
                  case 2:
                    newClass = "inv-item-armor-silver";
                    break;
                  case 3:
                    newClass = "inv-item-armor-gold";
                    break;
                }
                this.$refs[reference][0].classList.add(newClass);
                this.$forceUpdate();
                this.$refs.showStd.$forceUpdate();
              }
            });
        },
      });
    },
    filterEquipment(equipment, type) {
      if (equipment) {
        return equipment.filter((gear) => {
          return gear.type == type;
        });
      }
    },
    updateAvatar() {
      this.image.generateBlob(
        (blob) => {
          if (blob != null) {
            let formData = new FormData();
            formData.append("avatar", blob, "avatar.png");
            if (this.admin) {
              formData.append("student_id", this.student.id);
            }
            axios
              .post(
                "/classroom/" + this.classroom.code + "/setting/updateavatar",
                formData,
                {
                  headers: {
                    "content-type": "multipart/form-data",
                  },
                }
              )
              .then((response) => {
                location.reload();
              });
          }
        },
        "image/png",
        0.8
      );
    },
  },
  computed: {
    filteredEntries() {
      if (this.behaviours) {
        return this.behaviours.filter((entry) => {
          return (
            (entry.pivot.created_at >= this.dateStart || !this.dateStart) &&
            (entry.pivot.created_at <= this.dateEnd || !this.dateEnd)
          );
        });
      }
    },
    filteredLogEntries() {
      return this.student.log_entries.filter((entry) => {
        return (
          (entry.created_at >= this.dateStart || !this.dateStart) &&
          (entry.created_at <= this.dateEnd || !this.dateEnd)
        );
      });
    },
    groupedData() {
      let array = _.groupBy(this.filteredEntries, "id");
      return array;
    },
    orderedEquipment: function () {
      return _.orderBy(this.student.equipment, "type");
    },
    orderedChallenges: function () {
      return _.orderBy(this.challenges, "datetime", "desc");
    },
  },
  watch: {
    groupedData: {
      immediate: true,
      handler() {
        let colorsOK = [
          "#c8e6c9",
          "#a5d6a7",
          "#81c784",
          "#66bb6a",
          "#4caf50",
          "#43a047",
          "#388e3c",
          "#2e7d32",
          "#1b5e20",
          "#003300",
          "#002200",
          "#001100",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
        ];
        let colorsKO = [
          "#ffccbc",
          "#ffab91",
          "#ff8a65",
          "#ff7043",
          "#ff5722",
          "#f4511e",
          "#e64a19",
          "#d84315",
          "#bf360c",
          "#570000",
          "#370000",
          "#170000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
        ];
        this.series = this.labels = [];
        let data = this.groupedData;
        let propes = [];
        for (let property1 in data) {
          propes.push(data[property1]);
        }
        this.labels = [];
        this.series = [];
        this.colors = [];
        propes.forEach((element) => {
          let behaviour = element[0];
          this.series.push(element.length);
          this.labels.push(
            "<i class='" +
              behaviour.icon +
              "'></i> " +
              this.trans.get(behaviour.name)
          );
          if (behaviour.xp + behaviour.hp + behaviour.gold >= 0) {
            this.colors.push(colorsOK[0]);
            colorsOK.shift();
          } else {
            this.colors.push(colorsKO[0]);
            colorsKO.shift();
          }
        });
      },
    },
  },
};
</script>
