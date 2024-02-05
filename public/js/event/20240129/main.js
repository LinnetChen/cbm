

const wrap = Vue.createApp({
    delimiters: ["%[", "]"],
    data() {
        return {
            tabData: [
                { sec: '01', type: '01' },
                { sec: '02', type: '01' },
                { sec: '03', type: '01' },
            ],
            swiper: null,
            aos: null,
            openLink:false,
            aside:true,
        }
    },
    methods: {
        tab(sec, type) {
            const index = this.tabData.findIndex(tab => tab.sec == sec);
            if (index !== -1) {
                this.tabData[index].type = type;
            }

            if (index == 1 && type == '01') {
                this.swiperInit();
            }

        },
        asideHide() {
            this.aside = !this.aside;
            console.log(this.aside);
        },
        init() {
            if (this.aos) {
                this.aos.destory();
            }
            this.$nextTick(() => {
                // Aos.init();

            })

        },
        swiperInit() {
            if (this.swiper) {
                this.swiper.destroy();
            }
            this.$nextTick(() => {
                this.swiper = new Swiper(".swiper", {
                    slidesPerView: 1,
                    spaceBetween: 24,
                    centeredSlides: true,
                    loop: true,
                    speed: 1000,
                    autoplay: true,
                    disableOnInteraction: false,
                    delay: 1000,
                    // effect:'fade',
                    breakpoints: {
                        1920: {
                            slidesPerView: 1,
                            slidesPerGroup: 1,
                        },
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                });
            })
        },
    },
    mounted() {
       let open = new Date('2024-02-06 10:00:00');
       let now = new Date().getTime();
       if(now >= open){
        this.openLink = true;
       }

    }
})


// AOS.init();
wrap.mount('#wrap');



const swiper = new Swiper(".swiper", {
    slidesPerView: 1,
    spaceBetween: 24,
    centeredSlides: true,
    loop: true,
    speed: 1000,
    autoplay: false,
    disableOnInteraction: false,
    delay: 1000,
    // effect:'fade',
    breakpoints: {
        1920: {
            slidesPerView: 1,
            slidesPerGroup: 1,
        },
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

