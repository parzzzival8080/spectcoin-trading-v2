<template>
  
  <v-app>
    <v-card
      class="mx-auto overflow-hidden"
      height="100%"
    >
            <v-app-bar
            color=""
            dark
          >
            <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>

            <v-toolbar-title>SPECTCOIN</v-toolbar-title>
          </v-app-bar>

          <v-navigation-drawer
            v-model="drawer"
            absolute
            temporary
          >
            <v-list
              nav
              dense
            >
              <v-list-item-group
                v-model="group"
                active-class="deep-purple--text text--accent-4"
              >
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon>mdi-home</v-icon>
                  </v-list-item-icon>
                  <v-list-item-title>Home</v-list-item-title>
                </v-list-item>

                <v-list-item>
                  <v-list-item-icon>
                    <v-icon>mdi-account</v-icon>
                  </v-list-item-icon>
                  <v-list-item-title>Account</v-list-item-title>
                </v-list-item>
              </v-list-item-group>
            </v-list>
          </v-navigation-drawer>
          <v-bottom-navigation
          absolute
          dark
          color="white"
          horizontal
          scroll-target="#scroll-threshold-example"
          scroll-threshold="500"
          shift
          
        >
          <v-btn @click="$router.push('/')">       
            <span>Home</span>
            <v-icon>mdi-home</v-icon>
          </v-btn>

          <v-btn @click="$router.push('/')">
            <span>Market</span>

            <v-icon>mdi-chart-line-stacked</v-icon>
          </v-btn>

          <v-btn @click="openTrade()">
            <span>Trade</span>
            <v-icon>mdi-briefcase-arrow-left-right-outline</v-icon>
          </v-btn>
          <v-btn @click="openFuture()">
            <span>Futures</span>

            <v-icon>mdi-autorenew</v-icon>
          </v-btn>
          <v-btn @click="openWallet()">
            <span>Assets</span>

            <v-icon>mdi-wallet-outline</v-icon>
          </v-btn>
          </v-bottom-navigation>
          <v-sheet
      id="scroll-threshold-example"
      class="overflow-y-auto pb-16"
      max-height="850"
    >
          <section >
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
                  <v-card style="background-color:#181a20">
                      <v-card-text>
                          <v-row justify-center>
                              <v-col cols="3" md="3" sm="3">
                                  <center>
                                      <v-img max-width="100%" src="/img/game/game-1.png"></v-img>
                                      <span  style="color:white">Mining</span> 
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
                  <v-card style="margin-top:10px; background-color:#181a20" >
                      <v-card-title>
                         <span ><h3 style="color:white">Market</h3> </span>
                      </v-card-title>
                      <v-card-text>
                          <v-row justify-center>
                            <!-- btc -->
                              <v-col cols="4" md="4" sm="4">
                                <span style="color:white">{{btc.symbol}}</span>
                              </v-col>
                              <v-col cols="4" md="4" sm="4">
                                <span style="color:red" v-if="btc.priceChangePercent < 0">
                                  {{(parseFloat(btc.lastPrice).toFixed(4))}}
                                </span>
                                <span style="color:green" v-if="btc.priceChangePercent > 0">
                                  {{(parseFloat(btc.lastPrice).toFixed(4))}}
                                </span>
                              </v-col>
                              <v-col cols="4" md="4" sm="4">
                                <v-card style="border:solid; radius:5px; background-color:red; padding: 5px" v-if="btc.priceChangePercent < 0">
                                  <center>
                                    <span style="color:white; padding:5px">{{btc.priceChangePercent}}%</span>
                                  </center> 
                                </v-card>
                                <v-card style="border:solid; radius:5px; background-color:green; padding: 5px" v-if="btc.priceChangePercent > 0">
                                  <center>
                                    <span style="color:white; padding:5px">{{btc.priceChangePercent}}%</span>
                                  </center> 
                                </v-card>
                              </v-col>
                              </v-row>

                              <v-row justify-center>
                                <!-- eth -->
                                  <v-col cols="4" md="4" sm="4">
                                    <span style="color:white">{{eth.symbol}}</span>
                                  </v-col>
                                  <v-col cols="4" md="4" sm="4">
                                    <span style="color:red" v-if="btc.priceChangePercent < 0">
                                      {{(parseFloat(eth.lastPrice).toFixed(4))}}
                                    </span>
                                    <span style="color:green" v-if="eth.priceChangePercent > 0">
                                      {{(parseFloat(eth.lastPrice).toFixed(4))}}
                                    </span>
                                  </v-col>
                                  <v-col cols="4" md="4" sm="4">
                                    <v-card style="border:solid; radius:5px; background-color:red; padding: 5px" v-if="eth.priceChangePercent < 0">
                                      <center>
                                        <span style="color:white; padding:5px">{{eth.priceChangePercent}}%</span>
                                      </center> 
                                    </v-card>
                                    <v-card style="border:solid; radius:5px; background-color:green; padding: 5px" v-if="eth.priceChangePercent > 0">
                                      <center>
                                        <span style="color:white; padding:5px">{{eth.priceChangePercent}}%</span>
                                      </center> 
                                    </v-card>
                                  </v-col>
                                  </v-row>


                                  <v-row justify-center>
                                    <!-- xrp -->
                                      <v-col cols="4" md="4" sm="4">
                                        <span style="color:white">{{xrp.symbol}}</span>
                                      </v-col>
                                      <v-col cols="4" md="4" sm="4">
                                        <span style="color:red" v-if="xrp.priceChangePercent < 0">
                                          {{(parseFloat(xrp.lastPrice).toFixed(4))}}
                                        </span>
                                        <span style="color:green" v-if="xrp.priceChangePercent > 0">
                                          {{(parseFloat(xrp.lastPrice).toFixed(4))}}
                                        </span>
                                      </v-col>
                                      <v-col cols="4" md="4" sm="4">
                                        <v-card style="border:solid; radius:5px; background-color:red; padding: 5px" v-if="xrp.priceChangePercent < 0">
                                          <center>
                                            <span style="color:white; padding:5px">{{xrp.priceChangePercent}}%</span>
                                          </center> 
                                        </v-card>
                                        <v-card style="border:solid; radius:5px; background-color:green; padding: 5px" v-if="xrp.priceChangePercent > 0">
                                          <center>
                                            <span style="color:white; padding:5px">{{xrp.priceChangePercent}}%</span>
                                          </center> 
                                        </v-card>
                                      </v-col>
                                      </v-row>

                                      <v-row justify-center>
                                        <!-- cardano -->
                                          <v-col cols="4" md="4" sm="4">
                                            <span style="color:white">{{ada.symbol}}</span>
                                          </v-col>
                                          <v-col cols="4" md="4" sm="4">
                                            <span style="color:red" v-if="ada.priceChangePercent < 0">
                                              {{(parseFloat(ada.lastPrice).toFixed(4))}}
                                            </span>
                                            <span style="color:green" v-if="ada.priceChangePercent > 0">
                                              {{(parseFloat(ada.lastPrice).toFixed(4))}}
                                            </span>
                                          </v-col>
                                          <v-col cols="4" md="4" sm="4">
                                            <v-card style="border:solid; radius:5px; background-color:red; padding: 5px" v-if="ada.priceChangePercent < 0">
                                              <center>
                                                <span style="color:white; padding:5px">{{ada.priceChangePercent}}%</span>
                                              </center> 
                                            </v-card>
                                            <v-card style="border:solid; radius:5px; background-color:green; padding: 5px" v-if="ada.priceChangePercent > 0">
                                              <center>
                                                <span style="color:white; padding:5px">{{ada.priceChangePercent}}%</span>
                                              </center> 
                                            </v-card>
                                          </v-col>
                                          </v-row>

                                          <v-row justify-center>
                                            <!-- ada -->
                                              <v-col cols="4" md="4" sm="4">
                                                <span style="color:white">{{ada.symbol}}</span>
                                              </v-col>
                                              <v-col cols="4" md="4" sm="4">
                                                <span style="color:red" v-if="ada.priceChangePercent < 0">
                                                  {{(parseFloat(ada.lastPrice).toFixed(4))}}
                                                </span>
                                                <span style="color:green" v-if="ada.priceChangePercent > 0">
                                                  {{(parseFloat(ada.lastPrice).toFixed(4))}}
                                                </span>
                                              </v-col>
                                              <v-col cols="4" md="4" sm="4">
                                                <v-card style="border:solid; radius:5px; background-color:red; padding: 5px" v-if="ada.priceChangePercent < 0">
                                                  <center>
                                                    <span style="color:white; padding:5px">{{ada.priceChangePercent}}%</span>
                                                  </center> 
                                                </v-card>
                                                <v-card style="border:solid; radius:5px; background-color:green; padding: 5px" v-if="ada.priceChangePercent > 0">
                                                  <center>
                                                    <span style="color:white; padding:5px">{{ada.priceChangePercent}}%</span>
                                                  </center> 
                                                </v-card>
                                              </v-col>
                                              </v-row>

                                              <v-row justify-center>
                                                <!-- sol -->
                                                  <v-col cols="4" md="4" sm="4">
                                                    <span style="color:white">{{sol.symbol}}</span>
                                                  </v-col>
                                                  <v-col cols="4" md="4" sm="4">
                                                    <span style="color:red" v-if="sol.priceChangePercent < 0">
                                                      {{(parseFloat(sol.lastPrice).toFixed(4))}}
                                                    </span>
                                                    <span style="color:green" v-if="sol.priceChangePercent > 0">
                                                      {{(parseFloat(sol.lastPrice).toFixed(4))}}
                                                    </span>
                                                  </v-col>
                                                  <v-col cols="4" md="4" sm="4">
                                                    <v-card style="border:solid; radius:5px; background-color:red; padding: 5px" v-if="sol.priceChangePercent < 0">
                                                      <center>
                                                        <span style="color:white; padding:5px">{{sol.priceChangePercent}}%</span>
                                                      </center> 
                                                    </v-card>
                                                    <v-card style="border:solid; radius:5px; background-color:green; padding: 5px" v-if="sol.priceChangePercent > 0">
                                                      <center>
                                                        <span style="color:white; padding:5px">{{sol.priceChangePercent}}%</span>
                                                      </center> 
                                                    </v-card>
                                                  </v-col>
                                                  </v-row>

                                                  <v-row justify-center>
                                                    <!-- sol -->
                                                      <v-col cols="4" md="4" sm="4">
                                                        <span style="color:white">{{doge.symbol}}</span>
                                                      </v-col>
                                                      <v-col cols="4" md="4" sm="4">
                                                        <span style="color:red" v-if="doge.priceChangePercent < 0">
                                                          {{(parseFloat(doge.lastPrice).toFixed(4))}}
                                                        </span>
                                                        <span style="color:green" v-if="doge.priceChangePercent > 0">
                                                          {{(parseFloat(doge.lastPrice).toFixed(4))}}
                                                        </span>
                                                      </v-col>
                                                      <v-col cols="4" md="4" sm="4">
                                                        <v-card style="border:solid; radius:5px; background-color:red; padding: 5px" v-if="doge.priceChangePercent < 0">
                                                          <center>
                                                            <span style="color:white; padding:5px">{{doge.priceChangePercent}}%</span>
                                                          </center> 
                                                        </v-card>
                                                        <v-card style="border:solid; radius:5px; background-color:green; padding: 5px" v-if="doge.priceChangePercent > 0">
                                                          <center>
                                                            <span style="color:white; padding:5px">{{doge.priceChangePercent}}%</span>
                                                          </center> 
                                                        </v-card>
                                                      </v-col>
                                                      </v-row>  


                                                          <v-row justify-center>
                                                            <!-- shib -->
                                                              <v-col cols="4" md="4" sm="4">
                                                                <span style="color:white">{{shib.symbol}}</span>
                                                              </v-col>
                                                              <v-col cols="4" md="4" sm="4">
                                                                <span style="color:red" v-if="shib.priceChangePercent < 0">
                                                                  {{(parseFloat(shib.lastPrice).toFixed(4))}}
                                                                </span>
                                                                <span style="color:green" v-if="shib.priceChangePercent > 0">
                                                                  {{(parseFloat(shib.lastPrice).toFixed(4))}}
                                                                </span>
                                                              </v-col>
                                                              <v-col cols="4" md="4" sm="4">
                                                                <v-card style="border:solid; radius:5px; background-color:red; padding: 5px" v-if="shib.priceChangePercent < 0">
                                                                  <center>
                                                                    <span style="color:white; padding:5px">{{shib.priceChangePercent}}%</span>
                                                                  </center> 
                                                                </v-card>
                                                                <v-card style="border:solid; radius:5px; background-color:green; padding: 5px" v-if="shib.priceChangePercent > 0">
                                                                  <center>
                                                                    <span style="color:white; padding:5px">{{shib.priceChangePercent}}%</span>
                                                                  </center> 
                                                                </v-card>
                                                              </v-col>
                                                              </v-row>

                                                              <v-row justify-center>
                                                                <!-- galx -->
                                                                  <v-col cols="4" md="4" sm="4">
                                                                    <span style="color:white">{{galx.symbol}}</span>
                                                                  </v-col>
                                                                  <v-col cols="4" md="4" sm="4">
                                                                    <span style="color:red" v-if="galx.priceChangePercent < 0">
                                                                      {{(parseFloat(galx.lastPrice).toFixed(4))}}
                                                                    </span>
                                                                    <span style="color:green" v-if="galx.priceChangePercent > 0">
                                                                      {{(parseFloat(galx.lastPrice).toFixed(4))}}
                                                                    </span>
                                                                  </v-col>
                                                                  <v-col cols="4" md="4" sm="4">
                                                                    <v-card style="border:solid; radius:5px; background-color:red; padding: 5px" v-if="galx.priceChangePercent < 0">
                                                                      <center>
                                                                        <span style="color:white; padding:5px">{{galx.priceChangePercent}}%</span>
                                                                      </center> 
                                                                    </v-card>
                                                                    <v-card style="border:solid; radius:5px; background-color:green; padding: 5px" v-if="galx.priceChangePercent > 0">
                                                                      <center>
                                                                        <span style="color:white; padding:5px">{{galx.priceChangePercent}}%</span>
                                                                      </center> 
                                                                    </v-card>
                                                                  </v-col>
                                                                  </v-row>
                      </v-card-text>
                  </v-card>
                  
          </v-container>
          </section>

          <v-responsive></v-responsive>
        </v-sheet>
        </v-card>
  </v-app>
</template>

<script>
export default {
  name: "app",

  data() {
      return {
          drawer: false,
          group: null,
          fab: null,
          userId: sessionStorage.getItem("user-id"),
          color: "",
          flat: null,
          btc: [],
          eth: [],
          xrp: [],
          ada: [],
          sol: [],
          doge: [],
          polkadot: [],
          shib: [],
          galx: [],
          errors: [],
          timer: '',

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
      this.timer = setInterval(this.fetchMarket, 3000)
  },

  methods: {
      fetchMarket() {
          axios
              .get('/api/v1/top-list')
              .then(response => {
                      this.btc = response.data.btc
                      this.eth = response.data.eth
                      this.xrp = response.data.xrp
                      this.ada = response.data.cardano
                      this.sol = response.data.sol
                      this.doge = response.data.doge
                      this.polkadot = response.data.polkadot
                      this.shib = response.data.shib
                      this.galx = response.data.galx

                  })
              .catch(error => {
                  console.log(error);
              })
              .finally(() => {
                 
              });
      },

      openTrade()
      {
        clearInterval(this.timer)
        this.$router.push('/spot/orders')
      },

      openMarket()
      {
        clearInterval(this.timer)
        this.$router.push('/market')
      },

      openFuture()
      {
        clearInterval(this.timer)
        this.$router.push('/future/orders')
      },

      openWallet()
      {
        clearInterval(this.timer)
        this.$router.push('/wallet/spot')
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
      this.getUserGeolocation();
      this.fetchHospitals();
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
