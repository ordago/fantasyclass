<template>
  <div
    class="columns p-2 pr-0 h-100 mr-0"
    v-bind:class="{ 'has-bg-student': !admin }"
  >
    <div class="column is-narrow pr-0 noprint" ref="studentInfo">
      <div
        class="card rounded card-shadow-s"
        style="min-width: 275px; overflow: visible"
      >
        <show-character
          ref="showStd"
          :feed="!admin"
          :student="student"
          :classroom="classroom"
          :show-skills="false"
        ></show-character>
        <div class="card-content">
          <div
            class="is-flex is-flex-direction-row has-text-center mb-2"
            style="justify-content: center; margin-top: -20px"
            v-if="settings.skill_enabled == 1 || admin"
          >
            <ShowSkill
              v-for="skill in student.skills"
              :key="'skill-' + skill.id"
              :skill="skill"
              :code="classroom.code"
              :admin="admin"
              :use="true"
            ></ShowSkill>

            <span
              v-for="index in 4 - student.skills.length"
              :key="'index-' + index"
              class="mx-1 is-flex has-all-centered skill-container-big"
              @click="buySkill()"
            >
              <i class="p-4 cursor-pointer fas fa-plus has-text-light"></i>
            </span>
          </div>
          <div class="media mb-0 has-all-centered">
            <div class="media-left" v-if="classroom.character_theme">
              <figure class="image is-48x48">
                <img :src="student.avatar" class="rounded" alt />
              </figure>
            </div>
            <div class="media-content">
              <p class="title is-4">
                {{ student.name }}
                <span v-if="!admin && settings.impostor != -1"
                  ><i
                    v-tippy
                    :content="getImpostor()"
                    class="fad fa-user-secret"
                  ></i
                ></span>
              </p>
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
      <div class="mt-0 is-flex columns px-1" v-if="admin">
        <div class="column pr-1 is-narrow has-text-right">
          <button class="button" @click="nextStudent(false)">
            <i class="fas fa-chevron-left mr-1"></i>
            {{ trans.get("pagination.previous") }}
          </button>
        </div>
        <div class="column px-0">
          <tippy
            class="w-100"
            interactive
            :animate-fill="false"
            theme="light"
            placement="bottom"
            animation="fade"
            trigger="click"
            style="display: inline-block"
            arrow
          >
            <template v-slot:trigger>
              <button type="submit" class="button is-primary w-100">
                <i class="fas fa-user"></i>
              </button>
            </template>
            <span>
              <section>
                <b-autocomplete
                  v-model="name"
                  placeholder="e.g. Anne"
                  :open-on-focus="true"
                  :data="filteredDataObj"
                  field="name"
                  @select="(option) => goTo(option.id)"
                  :clearable="false"
                >
                </b-autocomplete>
              </section>
            </span>
          </tippy>
        </div>
        <div class="column pl-1 is-narrow">
          <button class="button is-info" @click="nextStudent">
            {{ trans.get("pagination.next") }}
            <i class="fas fa-chevron-right ml-1"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="column pr-0 pt-0">
      <b-tabs
        :destroy-on-hide="false"
        multiline
        expanded
        :animated="false"
        @input="setCookie()"
        v-model="activeTab"
        :key="update"
        class="pt-1"
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
              :content="getTippy(charclass.property)"
              @contextmenu.prevent=""
              @click="confirmChangeClass(charclass.id)"
              v-bind:class="{ selected: charclass.id == student.character_id }"
              class="p-2 m-2 rounded"
              :src="'/img/character/characters/' + charclass.id + '.png'"
              v-for="charclass in classroom.character_theme.characters"
              v-bind:key="'char' + charclass.id"
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
          class=""
          icon="backpack"
          icon-pack="fad"
        >
          <article
            class="message mt-2 mb-5 ml-0 pl-0 is-dark"
            v-if="
              !admin && settings.announcement && settings.announcement != ''
            "
          >
            <div class="message-header">
              <p>
                <i class="fad fa-bullhorn mr-1"></i>
                {{ trans.get("utils.announcement") }}
              </p>
            </div>
            <div class="message-body">
              {{ settings.announcement }}
            </div>
          </article>
          <article
            class="message is-dark my-2 mb-5"
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

          <div v-if="admin">
            <div
              class="columns is-mobile is-multiline is-variable mt-1"
              v-if="classroom.character_theme"
              :key="forceReload"
            >
              <div
                class="
                  column
                  p-1
                  is-4-tablet is-6-mobile is-2-desktop is-2-fullhd
                "
                v-for="gear in orderedEquipment"
                v-bind:key="'gear-' + gear.id"
              >
                <div
                  v-tippy
                  :content="propertiesMessage(gear)"
                  :ref="'item' + gear.id"
                  class="w-100 inventory-item inv-item-armor relative rounded"
                  v-bind:class="{
                    offset0: gear.offset == 0,
                    'inv-item-armor-bronce': gear.offset == 1,
                    'inv-item-armor-silver': gear.offset == 2,
                    'inv-item-armor-gold': gear.offset == 3,
                  }"
                >
                  <img
                    :src="'/img/character/' + gear.src"
                    :alt="gear.id"
                    class="item"
                    @contextmenu.prevent=""
                  />
                  <div>
                    <i class="fas fa-plus"></i>
                  </div>
                  <div
                    class="w-100 shop-sub-item"
                    style="position: absolute; top: 100px; left: 0"
                  >
                    <div v-for="(i, index) in getProperties()" :key="index">
                      <div
                        v-for="itemStore in filterEquipment(i, gear.type)"
                        v-bind:key="'store-' + itemStore.id"
                        class="inventory-item inv-item-armor w-100"
                        v-bind:class="{
                          offset0: index == 0,
                          'inv-item-armor-bronce': index == 1,
                          'inv-item-armor-silver': index == 2,
                          'inv-item-armor-gold': index == 3,
                        }"
                      >
                        <img
                          v-tippy
                          :content="propertiesMessage(itemStore)"
                          :src="'/img/character/' + itemStore.src"
                          :alt="itemStore.id"
                          class="item"
                          @contextmenu.prevent=""
                        />
                        <div
                          class="price-buy rounded"
                          v-if="!admin"
                          @click="buyEquipment(gear, itemStore)"
                        >
                          {{ calculate(itemStore) }}
                          <i class="fas fa-coins colored"></i>
                        </div>
                        <div
                          v-if="admin"
                          class="price-buy rounded"
                          @click="assignEquipment(gear, itemStore)"
                        >
                          {{ trans.get("general.assign") }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="columns is-multiline is-variable mt-3" v-if="admin">
            <div
              v-for="item in items"
              class="
                column
                py-2
                is-6-tablet is-12-mobile is-4-desktop is-3-fullhd
              "
              v-bind:key="'item2-' + item.id"
            >
              <b-field>
                <p class="control">
                  <img :src="item.icon" @contextmenu.prevent="" />
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
          <div
            class="is-flex is-flex-direction-column mt-4 p-2"
            id="inventory"
            v-if="!admin"
          >
            <div class="columns is-mobile is-multiline is-variable">
              <div
                v-if="student.items.length >= 1"
                @click="isCraftingModalActive = true"
                class="
                  column
                  p-1
                  is-6-mobile is-4-tablet is-2-desktop is-2-fullhd
                "
                v-tippy
                content="Crafting"
              >
                <div
                  class="
                    w-100
                    inventory-item inventory-item-dark
                    has-text-light
                    rounded
                  "
                >
                  <i class="fad fa-hammer" style="font-size: 3.5em"></i>
                  <!-- <small class="bl-sz">Crafting</small> -->
                </div>
              </div>
              <div
                v-for="item in student.items"
                v-tippy
                :content="message(item)"
                v-show="item.pivot.count > 0"
                class="
                  column
                  p-1
                  is-4-tablet is-6-mobile is-2-desktop is-2-fullhd
                "
                v-bind:key="'item3-' + item.id"
              >
                <div class="inventory-item rounded w-100">
                  <img
                    :src="item.icon"
                    @contextmenu.prevent=""
                    @click="
                      item.hp > 0 || item.xp > 0
                        ? useItem(item, message(item))
                        : null
                    "
                    class="item rounded"
                  />
                  <div class="number-items">{{ item.pivot.count }}</div>
                </div>
              </div>
              <div
                v-for="index in inventoryRemaining"
                class="
                  column
                  p-1
                  is-4-tablet is-6-mobile is-2-desktop is-2-fullhd
                "
                v-bind:key="'index2' + index"
              >
                <div class="inventory-item rounded w-100"></div>
              </div>
            </div>
            <div
              class="columns is-mobile is-multiline is-variable"
              v-if="classroom.character_theme"
            >
              <div
                class="
                  column
                  p-1
                  is-4-tablet is-6-mobile is-2-desktop is-2-fullhd
                "
                v-for="gear in orderedEquipment"
                v-bind:key="'gear2-' + gear.id"
              >
                <div
                  v-tippy
                  :content="propertiesMessage(gear)"
                  :ref="'item' + gear.id"
                  class="w-100 inventory-item inv-item-armor relative rounded"
                  v-bind:class="{
                    offset0: gear.offset == 0,
                    'inv-item-armor-bronce': gear.offset == 1,
                    'inv-item-armor-silver': gear.offset == 2,
                    'inv-item-armor-gold': gear.offset == 3,
                  }"
                >
                  <img
                    @contextmenu.prevent=""
                    :src="'/img/character/' + gear.src"
                    :alt="gear.id"
                    class="item"
                  />
                  <div
                    class="price-buy rounded"
                    style="left: 2px; right: initial"
                    v-if="gear.offset != 0"
                    v-tippy
                    :key="forceReload"
                    :content="
                      trans.get('students.repair') +
                      ': ' +
                      settings.repair_equipment +
                      ' <i class=\'fas fa-coins colored\'></i>'
                    "
                    @click="repair(gear)"
                  >
                    <i
                      v-if="gear.pivot.durability < 100"
                      class="fad fa-gavel faa-wrench animated"
                    ></i>
                    {{ gear.pivot.durability }} %
                  </div>
                  <div
                    class="price-buy rounded not-hover"
                    v-if="eq1Json || eq2Json || eq3Json || isInGear(gear.id)"
                  >
                    <i class="fas fa-plus"></i>
                  </div>
                  <div
                    class="w-100 shop-sub-item p-1"
                    style="position: absolute; top: 100px; left: 0"
                  >
                    <div
                      v-for="(i, index) in getProperties()"
                      :key="'index3-' + index"
                    >
                      <div
                        v-for="itemStore in filterEquipment(i, gear.type)"
                        v-bind:key="'item4-' + itemStore.id"
                        class="inventory-item inv-item-armor w-100"
                        v-bind:class="{
                          hidden: !notInOffset0(itemStore.id),
                          offset0: index == 0,
                          'inv-item-armor-bronce': index == 1,
                          'inv-item-armor-silver': index == 2,
                          'inv-item-armor-gold': index == 3,
                        }"
                      >
                        <img
                          @contextmenu.prevent=""
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
            </div>
            <div class style="clear: both"></div>
          </div>
          <div
            class="shop pt-3"
            v-if="itemsJson || settings.allow_buy_cards == 1"
          >
            <h2 class="is-size-2">
              <i class="fas fa-store"></i> {{ trans.get("menu.shop") }}
            </h2>
            <div v-if="settings.allow_buy_cards == 1">
              <button class="button is-primary m-2 mt-3" @click="buyCard">
                <i class="fas fa-envelope mr-1"></i
                ><i class="fak fa-deck mr-2"></i>
                {{ trans.get("shop.random_card") }} ({{ settings.card_price }}
                <i class="fas fa-coins colored"></i>)
              </button>
            </div>

            <div
              class="columns p-4 m-2 rounded"
              v-for="item in itemsJson"
              :key="'item5-' + item.id"
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
                <img @contextmenu.prevent="" :src="item.icon" />
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
          :label="trans.get('menu.progress')"
          icon="tasks"
          icon-pack="fad"
          class="p-2"
        >
          <div
            v-if="!mutableChallenges || mutableChallenges.length === 0"
            class=""
          >
            <article class="message is-info my-2">
              <div class="message-body">
                <i class="fas fa-info-square"></i>
                {{ trans.get("challenges.show_all_summary_empty") }}
                <a
                  :href="'/classroom/show/' + classroom.code + '/challenges'"
                  >{{ trans.get("menu.challenges") }}</a
                >
              </div>
            </article>
            <div
              class="
                content
                has-text-centered
                rounded
                m-3
                has-all-centered
                p-4
                has-background-warning
              "
            >
              <h1>
                <i class="fas fa-dungeon"></i>
                {{ trans.get("challenges.challenges_empty") }}
              </h1>
            </div>
          </div>
          <div v-else>
            <a
              :href="'/classroom/show/' + classroom.code + '/challenges'"
              class="button is-link mt-2 mb-3"
            >
              {{ trans.get("challenges.show_all_summary") }}
            </a>
            <div
              class="has-text-centered"
              v-for="(challenge, index) in orderedChallenges"
              :key="'challenge-' + challenge.id"
            >
              <show-challenge
                class="has-text-left"
                :challenge="challenge"
                :code="classroom.code"
                :admin="admin"
                :edit="false"
              ></show-challenge>
              <span v-if="index != orderedChallenges.length - 1"
                ><i class="far fa-arrow-up"></i
              ></span>
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
            :blogsp="student.blogsp"
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
            <div v-for="pet in pets" :key="'pet-' + pet.id" class="p-2 m-2">
              <div class="columns mb-0">
                <div class="column is-narrow">
                  <img
                    v-tippy="{
                      theme: 'light bordered',
                      placement: 'bottom',
                      arrow: true,
                    }"
                    @contextmenu.prevent=""
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
                    {{ trans.get("shop.adopt") }} {{ pet.price }}
                    <i class="fas fa-coins colored" style="z-index: 0"></i>
                  </button>
                </div>
              </div>
              <hr class="mt-0" />
            </div>
          </div>
          <div v-else>
            <div
              v-for="pet in classroom.pets"
              :key="'pet2-' + pet.id"
              class="p-2 m-2"
            >
              <div class="columns mb-0">
                <div class="column is-narrow">
                  <img
                    v-tippy="{
                      theme: 'light bordered',
                      placement: 'bottom',
                      arrow: true,
                    }"
                    @contextmenu.prevent=""
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
          class="p-2"
          v-if="classroom.collections && classroom.collections.length"
        >
          <template slot="header">
            <span class="icon"><i class="fak fa-collection fa-lg"></i></span>
            {{ trans.get("menu.collections") }}
          </template>

          <button class="button is-primary" @click="prepareExchange()">
            <i class="fas fa-exchange mr-1"></i>
            {{ trans.get("collections.exchange") }}
          </button>
          <div
            v-for="collection in classroom.collections"
            :key="'collection-' + collection.id"
          >
            <div
              v-if="
                collection.collectionables &&
                collection.collectionables.length &&
                collection.disabled != 1
              "
            >
              <h3 class="is-size-3 m-2">
                <i class="fak fa-collection mr-2"></i>
                <span
                  v-if="getCollectionNumber(collection.id) > 0"
                  class="collectionable-count mr-0"
                  style="
                    position: relative;
                    display: inline-flex;
                    font-size: 1em;
                    top: 0;
                    left: 0;
                  "
                  >{{ getCollectionNumber(collection.id) }}</span
                >
                {{ collection.name }}
                <small
                  >({{ collection.xp }}
                  <i class="fas fa-fist-raised colored"></i>,
                  {{ collection.gold }}
                  <i class="fas fa-coins colored"></i>)</small
                >
                <span
                  class="button is-info"
                  @click="claimReward(collection)"
                  v-if="
                    !admin &&
                    checkReward(collection) &&
                    (getCollectionNumber(collection.id) === 0 ||
                      collection.max != getCollectionNumber(collection.id))
                  "
                  >{{ trans.get("collections.claim_reward") }}</span
                >
              </h3>
              <div>
                <button
                  v-if="
                    settings.buy_collectionable == 1 &&
                    !admin &&
                    (getCollectionNumber(collection.id) === 0 ||
                      collection.max != getCollectionNumber(collection.id))
                  "
                  class="button is-dark mb-1"
                  @click="buyCollectionablePack(collection.id)"
                >
                  <i class="fas fa-envelope mr-1" aria-hidden="true"></i>
                  {{ trans.get("collections.buy_pack") }} ({{
                    settings.buy_collectionable_count
                  }}
                  <i class="fak fa-collection mx-1" aria-hidden="true"></i> =
                  {{ settings.buy_collectionable_gold_pack }}
                  <i class="fas fa-coins colored"></i>)
                </button>
              </div>
              <div
                v-for="collectionable in orderedCollectionables(
                  collection.collectionables
                )"
                :key="collectionable.id"
                class="collectionable-container m-1"
              >
                <show-collectionable
                  :style="getStyle(collectionable.id, collection)"
                  :collectionable="collectionable"
                  :count="getCount(collectionable.id)"
                  :admin="false"
                ></show-collectionable>
              </div>
            </div>
          </div>
        </b-tab-item>
        <b-tab-item v-if="admin || cards.length">
          <template slot="header">
            <!-- <b-icon pack="fad" icon="club" /> -->
            <span class="icon"><i class="fak fa-deck fa-lg"></i></span>
            {{ trans.get("students.cards") }}
            <span
              class="tag is-link tag-notif"
              :class="{
                'is-danger': student.numcards[0] > student.numcards[1],
              }"
              style="left: 2px"
              >{{ student.numcards[0] }} / {{ student.numcards[1] }}</span
            >
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
              v-for="(card, index) in cardsMutable"
              :key="'index5-' + index"
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
          <show-data
            :admin="admin"
            :info="behaviours"
            type="behaviours"
            :id="student.id"
          >
          </show-data>
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
            <span
              v-if="student.badges.length"
              class="tag is-link tag-notif"
              style="left: 2px"
              >{{ student.badges.length }}</span
            >
          </template>
          <div v-if="admin" class="is-flex pl-4">
            <div
              class="mx-2"
              v-for="(badge, index) in classroom.badges"
              :key="'badge-' + index + badge.id"
            >
              <ShowBadge
                :student="student"
                :badge="badge"
                :admin="true"
              ></ShowBadge>
            </div>
            <div
              class="mx-2"
              v-for="(badge, index) in student.badges"
              :key="'badge2-' + index + badge.id"
            >
              <ShowBadge
                v-if="!badge.classroom_id"
                :student="student"
                :badge="badge"
                :admin="false"
              ></ShowBadge>
            </div>
          </div>
          <div class="is-flex pl-4" v-if="!admin">
            <div
              class="mx-2"
              v-for="(badge, index) in student.badges"
              :key="'badge3-' + index + badge.id"
            >
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
          <show-data
            :admin="admin"
            :info="student.log_entries"
            type="log"
            :id="student.id"
          >
          </show-data>
        </b-tab-item>
        <b-tab-item
          :label="trans.get('students.evaluation')"
          v-if="evaluation"
          class="p-2"
          icon="analytics"
          icon-pack="fad"
        >
          <div v-if="evaluation[1] && evaluation[1].length">
            <h3 class="is-size-3">{{ trans.get("evaluation.pending") }}</h3>
            <span
              @click="evalRubric(pending)"
              v-for="(pending, index) in evaluation[1]"
              :key="'pending-' + index"
            >
              <b-tag class="m-2 cursor-pointer">
                <i
                  class="fas mr-1"
                  :class="{
                    'fa-users': pending.subtype == 1,
                    'fa-user': pending.subtype == 2,
                  }"
                ></i>
                {{ pending.name }} -
                <span
                  v-if="
                    pending.subtype == 1 ||
                    (pending.subtype == 3 && pending.student_id != student.id)
                  "
                  >{{ pending.student_name }}</span
                >
                <span
                  v-else-if="
                    pending.subtype == 2 ||
                    (pending.subtype == 3 && pending.student_id == student.id)
                  "
                  >{{ trans.get("evaluation.autoeval") }}</span
                >
              </b-tag>
            </span>
          </div>
          <report
            :individual="false"
            :classroom="classroom"
            :admin="admin"
            :grades="evaluation[0]"
            :settings="settings"
          ></report>
          <div class="content">
            <table class="grades has-background-light">
              <th>{{ trans.get("evaluation.description") }}</th>
              <th>{{ trans.get("evaluation.grade_number") }}</th>
              <th>{{ trans.get("evaluation.tags") }}</th>
              <th>{{ trans.get("evaluation.feedback") }}</th>
              <tr
                v-for="(grade, index) in student.grades"
                :key="'index6-' + index"
              >
                <td>{{ grade.description }}</td>
                <td>
                  <span
                    v-if="
                      admin ||
                      (settings.eval_type != 1 && settings.eval_type != 2)
                    "
                  >
                    <span
                      v-if="grade.type == 1 && grade.rubric_id"
                      class="cursor-pointer"
                      @click="loadRubric(grade)"
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
                    :key="'index7-' + index"
                    >{{ tag.short }}</span
                  >
                </td>
                <td>{{ grade.pivot.feedback }}</td>
              </tr>
            </table>
          </div>
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
          <p class="modal-card-title" v-if="!rubric_info">{{ student.name }}</p>
          <p class="modal-card-title" v-else>
            {{ rubric_info.student_name }} ({{ rubric_info.name }})
          </p>
        </header>
        <section class="modal-card-body">
          <div
            class="div_rounded rubricRow marginRadius"
            v-for="rubricRow in rubric.rows"
            :key="'rubric-' + rubricRow.id"
          >
            <h2 class="description">{{ rubricRow.description }}</h2>
            <div class="rubricSubitems">
              <div
                class="rubricSubitem marginRadius"
                v-for="item in rubricRow.items"
                :key="'rubrici-' + item.id"
                :row="'row' + rubricRow.id"
                :item="'item' + item.id"
                @click="selectItem($event.target, rubricRow.id, item)"
              >
                <div class="rubricDetails">{{ item.description }}</div>
                <div class="rubricScore">{{ item.points }}</div>
              </div>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button
            class="button"
            type="button"
            @click="
              resetRubric();
              showRubric = false;
            "
          >
            {{ trans.get("general.close") }}
          </button>
          <button
            class="button is-success"
            :disabled="checkAllGrade()"
            type="button"
            v-if="rubric_info"
            @click="gradeRubric()"
          >
            {{ trans.get("evaluation.grade") }}
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
                :placeholder="trans.get('students.send_name')"
              >
                <option
                  :value="id"
                  v-for="(id, name) in students_money"
                  :key="'money-' + id"
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
    <b-modal
      :active.sync="isCraftingModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
      full-screen
      v-if="student.items.length >= 1"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get("shop.crafting") }}</p>
        </header>
        <section class="modal-card-body">
          <p>
            {{ trans.get("shop.crafting_info") }}
          </p>
          <div class="p-2 is-flex pb-4 has-background-light border m-2">
            <div
              @click="tryCraft"
              style="float: none; min-width: 140px"
              :class="{
                'faa-parent animated-hover': craft.length,
                a5: !craft.length,
              }"
              class="inventory-item inventory-item-dark has-text-light rounded"
            >
              <i class="fad fa-hammer faa-wrench" style="font-size: 3.5em"></i>
            </div>
            <span
              class="is-relative"
              v-for="craft in craft"
              :key="'crafting-' + craft.id"
            >
              <img
                @contextmenu.prevent=""
                @click="removeCraft(craft.id)"
                :src="craft.icon"
                width="64px"
                class="m-2 p-2 has-background-dark rounded"
              />
              <div
                @click="removeCraft(craft.id)"
                class="price-buy rounded not-hover"
              >
                <i class="fas fa-minus"></i>
              </div>
            </span>
          </div>
          <div class="is-relative">
            <span
              class="is-relative"
              v-for="item in student.items"
              :key="'item-' + item.id"
            >
              <img
                @contextmenu.prevent=""
                @click="addCraft(item)"
                width="64px"
                v-if="checkCraft(item.id)"
                :src="item.icon"
                class="m-2 p-2 has-background-dark rounded"
              />
              <div
                v-if="checkCraft(item.id)"
                @click="addCraft(item)"
                class="price-buy rounded not-hover"
              >
                <i class="fas fa-plus"></i>
              </div>
            </span>
          </div>
          <div class="" v-if="craftJson && craftJson.length">
            <h3 class="is-size-3 mt-2 mb-3">{{ trans.get("shop.recipes") }}</h3>
            <div
              class="is-flex is-center-vertically my-2"
              v-for="craft in craftJson"
              :key="'craft' + craft.id"
            >
              <img
                v-tippy
                :content="craft.description"
                @contextmenu.prevent=""
                :src="craft.icon"
                width="32px"
              />
              <i class="fas fa-equals mx-2"></i>
              <span
                class="is-flex is-center-vertically"
                v-for="(c, index) in craft.craft"
                :key="'c-' + c.key"
                ><img width="32px" @contextmenu.prevent="" :src="c.src" />
                <i
                  class="fas fa-plus mx-2"
                  v-if="index != craft.craft.length - 1"
                ></i
              ></span>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button
            class="button"
            type="button"
            @click="isCraftingModalActive = false"
          >
            {{ trans.get("general.close") }}
          </button>
        </footer>
      </div>
    </b-modal>
    <b-modal
      :active.sync="isCollectionableModalActive"
      has-modal-card
      trap-focus
      :full-screen="true"
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">
            {{ trans.get("collections.get_collectionables") }}
          </p>
        </header>
        <section class="modal-card-body">
          <div class="py-3 is-flex center-collectionables">
            <div
              class="is-block"
              v-for="(collectionable, index) in getCollectionables"
              :key="'getModal-' + index + '-' + collectionable.id"
            >
              <vue-flip
                v-if="isCollectionableModalActive"
                width="200px"
                height="280px"
                active-click
                :horizontal="true"
              >
                <template v-slot:front>
                  <img
                    src="/img/cardgen/collections/back_small.png"
                    @contextmenu.prevent=""
                  />
                </template>
                <template v-slot:back>
                  <show-collectionable
                    :collectionable="collectionable"
                    :admin="false"
                  ></show-collectionable>
                </template>
              </vue-flip>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button
            class="button"
            type="button"
            @click="isCollectionableModalActive = false"
          >
            {{ trans.get("general.close") }}
          </button>
        </footer>
      </div>
    </b-modal>
    <b-modal
      :active.sync="isExchangeModalActive"
      has-modal-card
      trap-focus
      :full-screen="true"
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">
            {{ trans.get("collections.get_collectionables") }}
          </p>
        </header>
        <section class="modal-card-body">
          <div class="py-3">
            <div>
              <span v-if="exchanging == 0">
                <button class="button" @click="exchanging = 1">
                  {{ trans.get("collections.request") }}
                </button>
                <article class="message is-warning mt-1">
                  <div class="message-body">
                    {{ trans.get("collections.exchange_info") }}
                  </div>
                </article>
              </span>
              <div>
                <div v-if="exchanging == 0">
                  <div
                    v-for="(collectionable, index) in exchange"
                    :key="'ex-' + index"
                    class="columns m-1 is-flex"
                  >
                    <div class="column is-narrow is-flex has-all-centered p-2">
                      <img width="64px" :src="collectionable.student.avatar" />
                      <span class="ml-2">{{
                        collectionable.student.name
                      }}</span>
                    </div>
                    <div class="column is-narrow">
                      <show-collectionable
                        style="zoom: 50%"
                        :collectionable="collectionable.from"
                        :admin="false"
                      ></show-collectionable>
                    </div>
                    <div class="column is-narrow is-flex has-all-centered">
                      <i class="fas fa-arrows-h"></i>
                    </div>
                    <div class="column is-narrow">
                      <show-collectionable
                        style="zoom: 50%"
                        :collectionable="collectionable.to"
                        :admin="false"
                      ></show-collectionable>
                    </div>
                    <div class="column is-narrow is-flex has-all-centered p-2">
                      <span
                        v-if="collectionable.student.id != student.id"
                        v-tippy
                        :content="getMessageExchange(collectionable.to.id)"
                      >
                        <button
                          class="button is-success"
                          @click="doExchange(collectionable.id)"
                          :disabled="!canShare(collectionable.to.id)"
                        >
                          <i class="fas fa-exchange mr-1"></i>
                          {{ trans.get("collections.exchange") }}
                        </button>
                      </span>
                      <button
                        class="button is-danger"
                        @click="removeExchange(collectionable.id)"
                        v-else
                      >
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="" v-if="exchanging != 0">
              <div class="" v-if="exchanging == 1">
                <h3 class="is-size-3 mb-2">
                  {{ trans.get("collections.exchange_start") }}
                </h3>
                <div
                  v-for="collectionable in filterCollectibles()"
                  :key="collectionable.id"
                  class="collectionable-container m-1"
                >
                  <span
                    @click="
                      give = collectionable;
                      exchanging = 2;
                      $forceUpdate();
                    "
                  >
                    <show-collectionable
                      style="zoom: 75%"
                      :collectionable="collectionable"
                      :count="getCount(collectionable.id)"
                      :admin="false"
                    ></show-collectionable>
                  </span>
                </div>
              </div>
              <div class="" v-else-if="exchanging == 2">
                <h3 class="is-size-3 mb-2">
                  {{ trans.get("collections.exchange_end") }}
                </h3>

                <div
                  v-for="collection in classroom.collections"
                  :key="'ec-' + collection.id"
                >
                  <div
                    v-for="collectionable in orderedCollectionables(
                      collection.collectionables
                    )"
                    :key="collectionable.id"
                    class="collectionable-container m-1"
                    @click="
                      want = collectionable;
                      sendExchange();
                    "
                  >
                    <show-collectionable
                      style="zoom: 75%"
                      :style="getStyle(collectionable.id, collection)"
                      :collectionable="collectionable"
                      :count="getCount(collectionable.id)"
                      :admin="false"
                    ></show-collectionable>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button
            class="button"
            type="button"
            @click="isExchangeModalActive = false"
          >
            {{ trans.get("general.close") }}
          </button>
        </footer>
      </div>
    </b-modal>
    <random-card
      :card="randomCard"
      :admin="0"
      :code="classroom.code"
    ></random-card>
  </div>
</template>

<script>
import Utils from "../../utils.js";
import RandomCard from "../utils/RandomCard.vue";

import ShowBadge from "../badge/ShowBadge.vue";
import ShowSkill from "../skill/ShowSkill.vue";

import Blogs from "../blogs/Blogs.vue";
import Hp from "./Hp.vue";

import VueFlip from "vue-flip";

import confetti from "canvas-confetti";

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
    "section",
  ],
  components: {
    Blogs,
    Hp,
    ShowBadge,
    ShowSkill,
    RandomCard,
    "vue-flip": VueFlip,
  },
  created() {
    this.mutableChallenges = this.challenges;
    this.classroom.settings = this.settings;
  },
  mounted() {
    this.behaviours = this.student.behaviours;
    if (!this.admin) {
      this.updateEmpty();

      this.itemsJson = JSON.parse(this.shop.items);
    }
    this.eq0Json = JSON.parse(this.shop.eq0);
    this.eq1Json = JSON.parse(this.shop.eq1);
    this.eq2Json = JSON.parse(this.shop.eq2);
    this.eq3Json = JSON.parse(this.shop.eq3);
    if (this.shop.craft) this.craftJson = JSON.parse(this.shop.craft);
    if (this.section) {
      this.activeTab = parseInt(this.section);
    } else if (this.$cookies.get("tab")) {
      this.activeTab = parseInt(this.$cookies.get("tab"));
    } else {
      if (!this.admin) {
        this.activeTab = 1;
      }
    }
    if (this.admin) {
      const sendPostRequest = async () => {
        axios
          .get("/classroom/" + this.classroom.code + "/students/all")
          .then((response) => {
            this.students = response.data;
          });
      };
      sendPostRequest();
    }
    if (!this.admin && this.student.notifyLevel) {
      confetti({
        particleCount: 200,
        spread: 100,
        origin: { y: 1.0 },
      });
      this.$buefy.dialog.alert({
        title: "Level up! 👏👏",
        message: this.getLvlMessage(),
        type: "is-success",
        ariaRole: "alertdialog",
        ariaModal: true,
      });
    }
  },
  data: function () {
    return {
      give: null,
      want: null,
      activeTab: 0,
      dateStart: null,
      dateEnd: null,
      update: 0,
      grade: null,
      inventoryRemaining: 0,
      itemsJson: null,
      eq0Json: null,
      eq1Json: null,
      eq2Json: null,
      eq3Json: null,
      craftJson: null,
      forceReload: 0,
      forceReloadEq: 0,
      isSendMoneyActive: false,
      isCollectionableModalActive: false,
      isExchangeModalActive: false,
      prevImage: null,
      isCraftingModalActive: false,
      image: null,
      behaviours: null,
      isAssignModalActive: false,
      showRubric: false,
      rubric: null,
      eval_rubric: null,
      rubric_info: null,
      rowsSelected: [],
      send_money: 50,
      send_money_student: null,
      moneySended: false,
      transaction: null,
      keepFirst: false,
      openOnFocus: false,
      name: "",
      selected: null,
      clearable: false,
      mutableChallenges: [],
      students: [],
      getCollectionables: [],
      isCardModalActive: false,
      randomCard: null,
      cardsMutable: this.cards,
      craft: [],
      exchanging: 0,
      exchange: null,
    };
  },
  methods: {
    removeExchange(id) {
      axios
        .post("/classroom/" + this.classroom.code + "/exchange/delete", {
          id: id,
        })
        .then((response) => {
          this.$toast(this.trans.get("success_error.update_success"), {
            type: "success",
          });
          this.prepareExchange();
        });
    },
    doExchange(id) {
      axios
        .post("/classroom/" + this.classroom.code + "/exchange", { id: id })
        .then((response) => {
          if (response.data) {
            this.$toast(this.trans.get("success_error.update_success"), {
              type: "success",
            });
            this.student.collectionables = response.data;
            this.isExchangeModalActive = false;
          } else {
            this.$toast(this.trans.get("success_error.collectible_error"), {
              type: "error",
            });
          }
        });
    },
    prepareExchange() {
      this.exchanging = 0;
      axios
        .get("/classroom/" + this.classroom.code + "/exchange/get")
        .then((response) => {
          this.exchange = response.data;
          this.isExchangeModalActive = true;
        });
    },
    sendExchange() {
      this.exchanging = 0;
      if (this.give && this.want) {
        this.isExchangeModalActive = false;
        axios
          .post(
            "/classroom/" +
              this.classroom.code +
              "/student/exchangeCollectible",
            { from: this.give.id, to: this.want.id }
          )
          .then((response) => {
            this.$toast(this.trans.get("success_error.update_success"), {
              type: "success",
            });
          });
        // axios.post('/classroom/')
      }
    },
    getTippy(text) {
      if (text)
        return (
          this.trans.get("students.highlights") +
          " <i class='" +
          text +
          " colored'></i>"
        );
      return "";
    },
    notInOffset0(gearId) {
      return [680, 690, 700].findIndex((id) => id === gearId) === -1;
    },
    isInGear(gearId) {
      if ((gearId >= 660 && gearId <= 676) || (gearId >= 720 && gearId <= 751))
        return true;
      return false;
    },
    notInGear(gearId) {
      return (
        [
          41, 50, 640, 641, 642, 643, 644, 645, 646, 647, 648, 649, 658, 659,
          710, 711, 712, 713, 714, 715, 716, 717, 718,
        ].findIndex((id) => id === gearId) === -1
      );
    },
    getCollectionNumber(collection) {
      let count = 0;
      if (this.student.collections)
        this.student.collections.forEach((element) => {
          if (element.id == collection) {
            count = element.pivot.count;
          }
        });
      return count;
    },
    claimReward(collection) {
      let audio = new Audio("/sound/success.mp3");
      axios
        .post(
          "/classroom/" + this.classroom.code + "/student/collection/claim",
          { collection: collection.id }
        )
        .then((response) => {
          audio.play();
          confetti({
            particleCount: 200,
            spread: 100,
            origin: { y: 1.0 },
          });
          this.student.collections = response.data.collections;
          this.student.xp = response.data.student.xp;
          this.student.gold = response.data.student.gold;
          this.student.collectionables = response.data.collectionables;
          this.$forceUpdate();
        });
    },
    checkReward(collection) {
      let count = 0;
      this.student.collectionables.forEach((element) => {
        if (element.collection_id == collection.id) count++;
      });
      if (collection.collectionables.length == count) return true;
      return false;
    },
    getLvlMessage() {
      let msg =
        '<div class="content has-text-centered">' +
        '<span class="has-background-info-light p-2">Level: <strong>' +
        this.student.level.number +
        "</strong></span>" +
        '<br><br><img class="p-2 card-shadow-s is-full-rounded" src="' +
        this.student.level.imagelvl +
        '">';

      if (this.student.level.title)
        msg +=
          "<h3 class='is-size-3 mt-1'>" + this.student.level.title + "</h3>";
      if (this.student.level.description)
        msg +=
          "<h5 class='is-size-5 mt-0'>" +
          this.student.level.description +
          "</h5>";

      msg += "</div>";
      return msg;
    },
    tryCraft() {
      if (!this.craft || !this.craft.length) return false;
      let audio = new Audio("/sound/hammer.mp3");
      audio.play();
      let ids = [];
      this.craft.forEach((element) => {
        ids.push(element.id);
      });
      axios
        .post("/classroom/" + this.classroom.code + "/craft", { craft: ids })
        .then((response) => {
          if (response.data.type == "error") {
            this.$toast(response.data.message, {
              type: response.data.type,
            });
          } else {
            audio = new Audio("/sound/success.mp3");
            audio.play();
            confetti({
              particleCount: 200,
              spread: 100,
              origin: { y: 1.0 },
            });
            this.$buefy.dialog.alert({
              title: "Owww yeaahhhh 👏👏",
              message:
                '<div class="has-text-centered">' +
                this.trans.get("shop.craft_success") +
                ': <br><br> <img style="pointer-events: none" src="' +
                response.data.item.icon +
                '"><br><small><em>' +
                this.getDescription(response.data.item.description) +
                "</em></small></div>",
              type: "is-success",
              ariaRole: "alertdialog",
              ariaModal: true,
            });
            this.student.items = response.data.items;
            this.craft = [];
            this.$forceUpdate();
          }
        });
    },
    removeCraft(id) {
      var index = this.craft.findIndex(function (item) {
        return item.id === id;
      });
      this.craft.splice(index, 1);
    },
    addCraft(object) {
      this.craft.push(object);
      this.$forceUpdate();
    },
    checkCraft(id) {
      return !this.craft.find((object) => object.id == id);
    },
    getDescription(desc) {
      return desc ? desc : "";
    },
    buyCollectionablePack(id) {
      let audio = new Audio("/sound/success.mp3");
      this.$buefy.dialog.confirm({
        title: this.trans.get("collections.buy_pack"),
        message:
          "<span class='message-buy'>" +
          this.trans.get("collections.buy_collectionable_pack_info") +
          " (" +
          this.settings.buy_collectionable_count +
          "<i class='mx-2 fak fa-collection'></i> / " +
          this.settings.buy_collectionable_gold_pack +
          " <i class='fas fa-coins colored'></i>)</span>",
        confirmText: this.trans.get("shop.buy"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-link",
        iconPack: "fa",
        hasIcon: false,
        onConfirm: () => {
          axios
            .post(
              "/classroom/" + this.classroom.code + "/student/collection/buy",
              { collection: id }
            )
            .then((response) => {
              if (response.data.type == "success") {
                audio.play();
                this.getCollectionables = response.data.get_collectionables;
                this.isCollectionableModalActive = true;
                this.student.gold = response.data.gold;
                this.student.collectionables = response.data.collectionables;
                confetti({
                  particleCount: 200,
                  spread: 100,
                  origin: { y: 1.0 },
                });
                this.$forceUpdate();
              } else {
                this.$toast(response.data.message, {
                  type: response.data.type,
                });
              }
            });
        },
      });
    },
    buyCard() {
      this.$buefy.dialog.confirm({
        title: this.trans.get("shop.buy_card"),
        message:
          "<span class='message-buy'>" +
          this.trans.get("shop.buy_card_info") +
          " (" +
          this.settings.card_price +
          " <i class='fas fa-coins colored'></i>)</span>",
        confirmText: this.trans.get("shop.buy"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-link",
        iconPack: "fa",
        hasIcon: false,
        onConfirm: () => {
          axios
            .post("/classroom/" + this.classroom.code + "/student/card/buy")
            .then((response) => {
              if (response.data.type == "success") {
                this.randomCard = response.data.card;
                this.student.gold =
                  this.student.gold - this.settings.card_price;
                this.isCardModalActive = true;
                this.cardsMutable = response.data.cards;
                this.student.numcards = response.data.numcards;
                this.$forceUpdate();
              } else {
                this.$toast(response.data.message, {
                  type: response.data.type,
                });
              }
            });
        },
      });
    },
    buySkill() {
      this.$buefy.dialog.confirm({
        title: this.trans.get("skills.buy_skill"),
        message:
          "<span class='message-buy'>" +
          this.trans.get("skills.buy_skill_info") +
          " (" +
          this.settings.skill_price +
          " <i class='fas fa-coins colored'></i>)</span>",
        confirmText: this.trans.get("shop.buy"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-link",
        iconPack: "fa",
        hasIcon: false,
        onConfirm: () => {
          let id;
          if (this.admin) id = this.student.id;
          axios
            .post("/classroom/" + this.classroom.code + "/student/skills/buy", {
              id: id,
            })
            .then((response) => {
              this.$toast(response.data.message, { type: response.data.type });

              if (response.data.type == "success") {
                this.student.skills = response.data.skills;
                this.student.gold =
                  this.student.gold - this.settings.skill_price;
                this.$forceUpdate();
              }
            });
        },
      });
    },
    repair(gear) {
      if (gear.pivot.durability >= 100) return false;
      let audio = new Audio("/sound/repair.mp3");
      axios
        .post("/classroom/student/equipment/repair", {
          id: this.student.id,
          gear: gear.id,
        })
        .then((response) => {
          this.$toast(response.data.message, { type: response.data.type });
          if (response.data.type == "success") {
            audio.play();
            // setTimeout(() => {
            //   location.reload();
            // }, 1000);
            this.student.gold = response.data.gold;
            gear.pivot.durability = response.data.durability;
            // this.student.equipment = response.data.equipment;
            // this.forceReloadEq++;
            // this.$refs.equipment.$forceUpdate();
            // this.$parent.$forceUpdate();
            this.$forceUpdate();
          }
        });
    },
    getProperties() {
      return [this.eq0Json, this.eq1Json, this.eq2Json, this.eq3Json];
    },
    getImpostor() {
      if (this.settings.impostor)
        return "🤫 " + this.trans.get("utils.impostor");
      else return this.trans.get("utils.no_impostor");
    },
    setCookie() {
      this.$cookies.set("tab", this.activeTab, 60 * 5);
    },
    goTo(id) {
      location.href = "/classroom/" + this.classroom.code + "/student/" + id;
    },
    nextStudent(next = true) {
      const currentStudent = (element) => element.id == this.student.id;
      let nextId;
      let index;
      if (next) {
        index =
          (this.students.findIndex(currentStudent) + 1) % this.students.length;
      } else {
        index =
          (this.students.findIndex(currentStudent) - 1) % this.students.length;
        if (index == -1) index = this.students.length - 1;
      }
      nextId = this.students[index].id;

      this.goTo(nextId);
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
    getCount: function (collectionable) {
      let count = 0;
      let index = this.student.collectionables.findIndex(function (item, i) {
        if (item.id === collectionable) {
          count = item.pivot.count;
          return item.id === collectionable;
        }
      });
      return count;
    },
    getMessageExchange: function (collectionable) {
      if (!this.canShare(collectionable))
        return this.trans.get("collections.exchange_info_tippy");
      return this.trans.get("collections.exchange");
    },
    canShare: function (collectionable) {
      var index = this.student.collectionables.findIndex(function (item, i) {
        return item.id === collectionable;
      });
      if (index == -1) return false;
      if (this.student.collectionables[index].pivot.count <= 1) return false;
      return true;
    },
    getStyle: function (collectionable, collection) {
      if (
        this.getCollectionNumber(collection.id) != 0 &&
        collection.max == this.getCollectionNumber(collection.id)
      )
        return "";
      var index = this.student.collectionables.findIndex(function (item, i) {
        return item.id === collectionable;
      });
      if (index == -1) return "filter: grayscale(100%);";
    },
    lastBehaviour: function () {
      let behaviour =
        this.student.behaviours[this.student.behaviours.length - 1];
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
    gradeRubric: function () {
      this.$buefy.dialog.confirm({
        title: this.trans.get("evaluation.grade"),
        message: this.trans.get("evaluation.confirm_grade"),
        confirmText: this.trans.get("general.accept"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-warning",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          var elem = this;
          document
            .querySelectorAll(".selectedSubItem")
            .forEach(function (item) {
              elem.rowsSelected.push([
                item.getAttribute("row").replace("row", ""),
                item.getAttribute("item").replace("item", ""),
              ]);
            });
          axios
            .post(
              "/classroom/evaluation/" +
                this.rubric_info.id +
                "/evaluate/rubric",
              {
                student: this.rubric_info.student_id,
                rows: this.rowsSelected,
                evaluable: this.rubric_info.id,
                from_student: this.student.id,
                grade: this.grade,
              }
            )
            .then((response) => {
              let rubric_info = this.rubric_info;
              var index = this.evaluation[1].findIndex(function (item, i) {
                return (
                  item.id === rubric_info.id &&
                  item.student_id === rubric_info.student_id
                );
              });
              this.evaluation[1].splice(index, 1);
              this.showRubric = false;
              this.rowsSelected = [];
              this.resetRubric();
              this.$toast(this.trans.get("success_error.update_success"), {
                type: "success",
              });
            });
        },
      });
    },
    resetRubric: function () {
      let images = document.querySelectorAll(".rubricSubitem img");
      images.forEach((element) => {
        element.remove();
      });
      var lights = document.getElementsByClassName("selectedSubItem");
      while (lights.length) lights[0].classList.remove("selectedSubItem");
      this.rubric_info = null;
      this.grade = null;
      this.$forceUpdate();
    },
    checkAllGrade: function () {
      var lights = document.getElementsByClassName("selectedSubItem");
      return lights.length !== this.rubric.rows.length;
    },
    selectItem: function (target, row, item) {
      if (this.rubric_info) {
        let element = document.querySelector("[item=item" + item.id + "]");
        document
          .querySelectorAll("[row=row" + row + "]")
          .forEach(function (rowItem) {
            rowItem.classList.remove("selectedSubItem");
          });

        element.classList.add("selectedSubItem");
        this.recalculate();
      }
    },
    recalculate: function () {
      let total = 0;
      let totalSelected = 0;
      let totalOptional = 0;

      document
        .querySelectorAll(
          ".rubricSubitems:not([data-info=data-optional]) .rubricSubitem.selectedSubItem"
        )
        .forEach(function (rowItem) {
          totalSelected += parseFloat(
            rowItem.querySelector(".rubricScore").innerHTML
          );
        });

      document
        .querySelectorAll(".rubricSubitems:not([data-info=data-optional])")
        .forEach(function (row) {
          var max = 0;
          row.querySelectorAll(".rubricSubitem").forEach((item) => {
            let score = parseFloat(
              item.querySelector(".rubricScore").innerHTML
            );
            if (score > max) max = score;
          });
          total += max;
        });

      // TODO optional rows
      // $('.rubricSubitems[data-info=data-optional]').find('.rubricSubitem.selectedSubItem').each(function(index){
      //     totalOptional += parseFloat($(this).find('.rubricScore').html());
      // });

      this.grade = Math.min(
        this.settings.eval_max,
        Math.round(
          ((totalSelected / total) * this.settings.eval_max + totalOptional) *
            100
        ) / 100
      );
      this.$forceUpdate();
    },
    evalRubric: function (pending) {
      this.resetRubric();
      axios
        .post("/classroom/evaluation/rubric", {
          rubric: pending.rubric_id,
        })
        .then((response) => {
          this.rubric = response.data;
          this.eval_rubric = true;
          this.rubric_info = pending;
          this.showRubric = true;
        });
    },
    loadRubric: function (grade) {
      this.resetRubric();
      axios
        .post("/classroom/evaluation/rubric", {
          rubric: grade.rubric_id,
        })
        .then((response) => {
          this.rubric = response.data;
          this.showRubric = true;

          axios
            .post("/classroom/evaluation/student/rubric", {
              student: this.student.id,
              rubric: grade.rubric_id,
              evaluable: grade.id,
            })
            .then((response) => {
              response.data[0].forEach((row) => {
                document
                  .querySelector(
                    "[row=row" + row[0] + "][item=item" + row[1] + "]"
                  )
                  .classList.add("selectedSubItem");
              });
              response.data[1].forEach((row) => {
                let img = document.createElement("img");
                img.src = row[2].avatar;
                img.title = row[2].name;
                img.classList = "rubric-student is-full-rounded";
                document
                  .querySelector(
                    "[row=row" + row[0] + "][item=item" + row[1] + "]"
                  )
                  .appendChild(img);
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
    updateEmpty() {
      let n = this.student.items.length;
      if (n % 6) n = n + (6 - (n % 6));
      this.inventoryRemaining =
        n - this.student.items.length ? n - this.student.items.length - 1 : 5;
    },
    confirmChangeClass(subclass) {
      if (this.classroom.character_theme.id == 10) {
        axios
          .post(
            "/classroom/" + this.classroom.code + "/student/changecharacter",
            { id: this.student.id, character_id: subclass, mode: "student" }
          )
          .then((response) => {
            location.reload();
          });
      } else {
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
                "/classroom/" +
                  this.classroom.code +
                  "/student/changecharacter",
                { id: this.student.id, character_id: subclass, mode: "student" }
              )
              .then((response) => {
                location.reload();
              });
          },
        });
      }
    },
    useItem(item, messageItem) {
      let audio = new Audio("/sound/success.mp3");
      this.$buefy.dialog.confirm({
        message:
          messageItem + " <br><br>" + this.trans.get("students.use_item_info"),
        onConfirm: () => {
          axios
            .post("/classroom/" + this.classroom.code + "/student/useitem", {
              id: this.student.id,
              itemId: item.id,
            })
            .then((response) => {
              if (!response.data) {
              } else {
                if (this.student.hp == 0) location.reload();
                item.pivot.count--;
                if (item.pivot.count == 0) this.inventoryRemaining++;
                this.student.hp = Math.min(
                  this.student.hp + response.data.hp,
                  100
                );
                this.student.xp = response.data.xp;
                this.forceRerender();
                audio.play();
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
    // getDate(date) {
    //   return Utils.getDate(date);
    // },
    message(item) {
      let message = "";
      if (item.slot > 0)
        message +=
          this.trans.get("shop.slot") +
          " +" +
          item.slot +
          " <i class='fak fa-deck colored mx-1'></i>. ";
      if (item.hp > 0) {
        message +=
          this.trans.get("shop.recovers_hp") +
          item.hp +
          " <i class='fas fa-heart colored'></i>. ";
        if (item.undead) message += this.trans.get("shop.undead") + ". ";
      }

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
      let message = "";
      if (itemStore.hp)
        message +=
          "<i class='fas fa-heart colored'></i> " + itemStore.hp + "%. ";

      if (itemStore.xp)
        message +=
          "<i class='fas fa-fist-raised colored'></i> " + itemStore.xp + "%. ";

      if (itemStore.gold)
        message +=
          "<i class='fas fa-coins colored'></i> " + itemStore.gold + "%. ";

      return message;
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
        title: this.trans.get("shop.adopt"),
        message: this.trans.get("shop.adopt_text") + "?",
        confirmText: this.trans.get("shop.adopt"),
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
    assignEquipment(oldItem, newItem) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.assign"),
        message: this.trans.get("shop.assign_eq_text"),
        confirmText: this.trans.get("general.assign"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-link",
        iconPack: "fa",
        hasIcon: false,
        onConfirm: () => {
          axios
            .post(
              "/classroom/" + this.classroom.code + "/student/assignequipment",
              {
                student: this.student.id,
                new: newItem,
              }
            )
            .then((response) => {
              this.$toast(response.data.message, { type: response.data.type });

              if (response.data.type == "success") {
                this.student.equipment = response.data.equipment;
                oldItem.src = newItem.src;
                let reference = "item" + oldItem.id;
                this.student.boost = response.data.boost;
                let newClass = "";
                this.$refs[reference][0].classList.remove(
                  "inv-item-armor-bronce"
                );
                this.$refs[reference][0].classList.remove(
                  "inv-item-armor-silver"
                );
                this.$refs[reference][0].classList.remove(
                  "inv-item-armor-gold"
                );
                switch (newItem.offset) {
                  case 1:
                    newClass = "inv-item-armor-bronce";
                    break;
                  case 2:
                    newClass = "inv-item-armor-silver";
                    break;
                  case 3:
                    newClass = "inv-item-armor-gold";
                    break;
                  default:
                    newClass = "inv-item-armor";
                    break;
                }
                if (newClass) this.$refs[reference][0].classList.add(newClass);
                this.$forceUpdate();
                this.$refs.showStd.$forceUpdate();
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
          "<i class='fas fa-coins colored'></i>? <br> (" +
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
    orderedCollectionables: function (collectionables) {
      return _.orderBy(collectionables, "type", "asc");
    },
    filterCollectibles: function () {
      return this.student.collectionables.filter((collectionable) => {
        return collectionable.pivot.count > 1;
      });
    },
  },
  computed: {
    filteredDataObj() {
      return this.students.filter((option) => {
        return (
          option.name
            .toString()
            .toLowerCase()
            .indexOf(this.name.toLowerCase()) >= 0
        );
      });
    },

    orderedEquipment: function () {
      return _.orderBy(
        this.student.equipment.filter((eq) => this.notInGear(eq.id)),
        "type"
      );
    },
    orderedChallenges: function () {
      return _.orderBy(
        this.mutableChallenges,
        ["pinned", "datetime"],
        ["desc", "desc"]
      );
    },
  },
};
</script>
<style>
.center-collectionables {
  justify-content: space-evenly;
}
.message-buy {
  line-height: 20px;
}
.bl-sz {
  position: absolute;
  bottom: 3px;
  right: 4px;
  font-size: 0.75em;
  font-style: italic;
  color: #aaa;
  font-weight: bold;
}
.has-bg-student .tabs {
  background-color: white;
  border-radius: 10px;
  border-bottom-right-radius: 10px;
  padding-top: 12px;
  margin-top: -5px;
}
.has-bg-student .tabs a {
  border-radius: 2px;
}
</style>