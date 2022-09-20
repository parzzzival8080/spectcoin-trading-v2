<template>
    <v-app>

        <views-navigation :color="color" :flat="flat" />
            <section id="hero" class="hero-section" >
                <v-carousel
                    cycle
                    height="auto"
                    show-arrows-on-hover
                    hide-delimiter-background
                >
                    <v-carousel-item v-for="(item,i) in items"
                    :key="i"
                    :src="item.src"
                    >
                    
                    </v-carousel-item>
                </v-carousel>
                <v-container>    
                    <v-card style="background:#181a20">
                        <v-card-text>
                            <v-row justify-center>
                                <v-col cols="3" md="3" sm="3">
                                    <center>
                                        <v-img max-width="100%" src="/img/game/game-1.png"></v-img>
                                        <span style="color:white">Mining</span> 
                                    </center>
                                    
                                </v-col>
                                <v-col cols="3" md="3" sm="3">
                                    <center>
                                        <v-img max-width="100%"  src="/img/game/game-2.png"></v-img>
                                        <span style="color:white">Blind Box</span> 
                                    </center>
                                    
                                </v-col>
                                <v-col cols="3" md="3">
                                    <center>
                                        <v-img max-width="100%" src="/img/game/game-3.png"></v-img>
                                        <span style="color:white">Guess</span> 
                                    </center>
                                </v-col>
                                <v-col cols="3" md="3">
                                    <center>
                                        <v-img max-width="100%" src="/img/game/game-4.png"></v-img>
                                        <span style="color:white">Finance</span> 
                                    </center>
                                    
                                </v-col>
                            </v-row> 
                        </v-card-text>
                    </v-card>
                    <v-card style="margin-top:10px">
                        <v-card-title>
                            Market
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                
                            </v-row>
                        </v-card-text>
                    </v-card>
                    
            </v-container>
            </section>
            
                
    </v-app>
</template>

<script>
export default {
    name: "app",

    data() {
        return {
            fab: null,
            userId: sessionStorage.getItem("user-id"),
            color: "",
            flat: null,

            //Google Maps Variables
            center: { lat: 6.9214, lng: 122.079 },
            address: { lat: 6.9214, lng: 122.079 },
            //Modals
            hospitalDialog: false,
            cryptos : [],
            errors: [],

            items: [
                {
                    src: '/img/banners/banner-1.png',

                },
                {
                    src: '/img/banners/banner-2.png',
                },
                {
                    src: '/img/banners/banner-3.png',
                },
        ],
        };

        
    },

    mounted() {
        this.fetchMarket()
    },

    methods: {
        fetchMarket() {
            axios
                .get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/market-pairs/latest')
                .then(response => {
                        this.cryptos = response.data
                    })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                   
                });
        },

        onScroll(e) {
            if (typeof window === "undefined") return;
            const top = window.pageYOffset || e.target.scrollTop || 0;
            this.fab = top > 60;
        },

        toTop() {
            this.$vuetify.goTo(0);
        },
    },

    watch: {
        fab(value) {
            if (value) {
                this.color = "#f8f9fa";
                this.flat = false;
            } else {
                this.color = "transparent";
                this.flat = true;
            }
        }
    },

    created() {
        this.toTop();
        const top = window.pageYOffset || 0;
        if (top <= 60) {
            this.color = "transparent";
            this.flat = true;
        }
    },

    beforeRouteEnter(to, from, next) {
        // if (sessionStorage.getItem("user-type")) {
        //     if (sessionStorage.getItem("user-type") == "ADMINISTRATOR") {
        //         return next("admin/dashboard");
        //     } else if (sessionStorage.getItem("user-type") == "SUBSCRIBER") {
        //         return next("/dashboard");
        //     }
        // }
        next();
    }
};
</script>
