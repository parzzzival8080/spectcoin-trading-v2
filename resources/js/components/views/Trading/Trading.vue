<template>
  
  <v-app>
    <v-card 
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
                <v-card>
                  <v-card-text>
                    <v-row >                      
                      <v-col cols="6">

                          <v-btn style="margin-right:5px;background-color:green; color:white">Buy</v-btn>
                          <v-btn style="background-color:red; color:white">Sell</v-btn>
                  

                          <v-text-field style="color:white" placeholder="AMOUNT ORDER"></v-text-field>
                          <v-text-field style="color:white" placeholder="PRICE PER COIN"></v-text-field>
                          <v-btn style="width:100%;background-color:green; color:white" @click="fetchOrder()">Buy</v-btn>
                      </v-col>
                      <v-col cols="6">
                          Orders
                          <v-row>
                              <v-col cols="6" md="6">
                                <span stlye="font-size:8px"> PRICE </span>
                                  <!-- {{orders.bids}} -->
                                <div >
                                  <v-row v-for="(order, index) in orders.bids" :key="index">
                                    <v-col cols="6">
                                      <span stlye="font-size:2px"> {{parseFloat(order[0]).toFixed(2)}} </span>
                                    </v-col>
                                    
                                    <!-- {{order[0]}} -->
                                    <!-- <div v-for="(bid, index) in order.bids" :key="index">
                                      {{bid}}
                                    </div> -->
                                  </v-row>  
                                </div>
                              </v-col>
                              <v-col cols="6" md="6">
                                AMOUNT
                                <v-row v-for="(order, index) in orders.bids" :key="index">
                                  <v-col cols="6">
                                      <span stlye="font-size:2px">{{parseFloat(order[1])}}</span>
                                  </v-col>
                                  
                                  <!-- {{order[0]}} -->
                                  <!-- <div v-for="(bid, index) in order.bids" :key="index">
                                    {{bid}}
                                  </div> -->
                                </v-row> 
                              </v-col>
                          </v-row>
                          <v-row>

                          </v-row>
                      </v-col>
                          
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-card>
          
       
  </v-app>
</template>

<script>
import axios from 'axios';

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
          orders: [],

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
      // this.fetchMarket()
  },

  methods: {
    fetchOrder()
    { 
        axios.get('/api/v1/getOrder')
        .then(response => {
                      this.orders = response.data.result
                      console.log(this.orders)
                  })
              .catch(error => {
                  console.log(error);
              })
              .finally(() => {
                 
              });
    },  
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
