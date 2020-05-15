<template>
    <div class="rounded card">
        <div class="card-header">
            {{ this.name }}
        </div>
        <div class="card-body">
            <div>
                <div class="centeredAttribute p-2 my-3">
                    <span class="attribute py-2 bg-light rounded" style="width:100%;">10</span>
                    <span class="attribute bg-light py-2 rounded" style="width:100%;"><span> </span><span v-if="hp<20">{{ this.hp }}</span></span>
                    <span class="attribute bg-danger py-2 rounded-left" v-bind:class="{ rounded: hp==100 }" :style="'width: ' + hp + '%'" v-if="hp>0"><i class="fas fa-heart"></i> <span v-if="hp>=20">{{ this.hp }}</span></span>
                </div>
                <div class="score p-2 mt-1">
                    <span>
                        <i class="fas fa-fist-raised colored"></i>
                    </span> {{ this.xp }}
                </div>
                <div class="changeScore my-2">
                    <button type="submit" class="btn btn-secondary btn-submit" value="100">+100</button>
                    <button type="submit" class="btn btn-secondary btn-submit" value="50">+50</button>
                    <button type="submit" class="btn btn-secondary btn-submit" value="10">+10</button>
                    <button type="submit" class="btn btn-primary btn-primary customValue" data-toggle="modal" data-target="#customXPmodal"><i class="fas fa-hashtag"></i></button>
                    <button type="submit" class="btn btn-outline-secondary btn-submit" value="-10">-10</button>
                    <button type="submit" class="btn btn-outline-secondary btn-submit" value="-50">-50</button>
                    <button type="submit" class="btn btn-outline-secondary btn-submit" value="-100">-100</button>
                </div>
                <div class="gold p-2 my-1">
                    <i class="fas fa-coins colored"></i> {{ this.gold }}
                </div>
                <div class="changeGold my-2">

                    <div class="changeGold">
                        <button type="submit" class="btn btn-warning btn-submit editgold" value="100">+100</button>
                        <button type="submit" class="btn btn-warning btn-submit editgold" value="50">+50</button>
                        <button type="submit" class="btn btn-warning btn-submit editgold" value="10">+10</button>
                        <button type="button" class="btn btn-primary" data-action="popover" data-tippy-content="Valor personalizado" data-toggle="modal" data-type="editGold" data-target="#customXPmodal"><i class="fas fa-hashtag"></i></button>
                        <button type="submit" class="btn btn-outline-secondary btn-submit editgold" value="-10">-10</button>
                        <button type="submit" class="btn btn-outline-secondary btn-submit editgold" value="-50">-50</button>
                        <button type="submit" class="btn btn-outline-secondary btn-submit editgold" value="-100">-100</button>
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
  import Utils from "../../utils.js";

  export default {
        props: ['student'],
        mounted() {
            let studentJson = JSON.parse(this.student);
            this.id = studentJson.id;
            this.name = studentJson.name;
            this.hp = studentJson.hp;
            this.xp = studentJson.xp;
            this.gold = studentJson.gold;
            this.password_plain = studentJson.password_plain;
        },
        data: function() {
            return {
                id: 0,
                name: '',
                hp: 0,
                xp: 0,
                gold: 0,
                password_plain: '',
            }
        },
        methods: {
            
        }
    }
</script>
