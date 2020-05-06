<template>
    <div>
        <button type="button" class="btn btn-secondary" @click="goNextTab"> {{ text }} <i class="fal fa-chevron-right"></i></button>
    </div>
</template>

<script>
    export default {
        props: ['text'],
        data: function() {
            return  {
                next: 'nameAndGoals',
                elem: null,
            }
        },
        methods: {
            goNextTab() {
                let elem = document.getElementById(this.next);
                let tabElem = document.querySelector('[href="#'+this.next+'"]');
                elem.classList.remove('active');
                tabElem.classList.remove('active');
                switch(this.next) {
                    case 'nameAndGoals':
                        this.next = 'cardsPanel';
                    break;
                    case 'cardsPanel':
                        this.next = 'levelsPanel';
                    break;
                    case 'levelsPanel':
                        this.next = 'themePanel';
                    break;
                    case 'themePanel':
                        this.next = 'characterPanel';
                    break;
                    case 'characterPanel':
                        this.next = 'infoPanel';
                    break;
                    case 'infoPanel':
                        this.next = 'nameAndGoals';
                    break;
                }
                elem = document.getElementById(this.next);
                tabElem = document.querySelector('[href="#'+this.next+'"]');
                elem.classList.add('active');
                tabElem.classList.add('active');
            },
        }
    }
</script>
