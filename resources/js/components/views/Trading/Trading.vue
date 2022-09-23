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
                <v-card>
                  <v-card-text>
                    <v-row > 
                                          
                      <v-col cols="6">
                          <v-btn style="margin-right:5px;background-color:green; color:white" @click="buyButton()">Buy</v-btn>
                          <v-btn style="background-color:red; color:white" @click="sellButton()">Sell</v-btn>
                          <v-text-field style="color:white" placeholder="AMOUNT ORDER" :value="parseFloat(btc.lastPrice).toFixed(4)"></v-text-field>
                          <v-text-field @changed="allowOrder()" style="color:white" v-model="inputAmount" placeholder="Amount" :value="inputAmount"></v-text-field>
                          <v-btn :color="buttonColor" v-model="buttonOrder"
                            :disabled="inputAmount == null || inputAmount <= 0"
                           style="width:100%; color:white" 
                           @click="commitOrder()">{{buttonLabel}}</v-btn>
                          <v-row style="margin-top:2px">
                            <v-col cols="3">
                              <v-sheet 
                              @click="quarterChange()"
                              :color="sheetColor25"
                              elevation="1"
                              height="10"
                              width="40px">
                              </v-sheet>
                              <center>25</center>
                            </v-col>
                            <v-col cols="3">
                              <v-sheet 
                              @click="halfChange()"
                              :color="sheetColor50"
                              elevation="1"
                              height="10"
                              width="40px">
                              </v-sheet>
                              <center>50</center>
                            </v-col>
                            <v-col cols="3">
                              <v-sheet 
                              @click="thirdChange()"
                              :color="sheetColor75"
                              elevation="1"
                              height="10"
                              width="40px">
                              </v-sheet>
                              <center>75</center>
                              </v-col>
                            <v-col cols="3">
                              <v-sheet 
                              @click="allInChange()"
                              :color="sheetColor100"
                              elevation="1"
                              height="10"
                              width="40px">
                              </v-sheet>
                              <center style="font-size:10px">100</center>
                            </v-col>
                          </v-row>
                          <v-row>
                            <v-col>
                              Available Balance:
                            </v-col>
                            <v-col>
                              ${{wallet.wallet_balance}}
                            </v-col>
                          </v-row>
                      </v-col>
                      <v-col cols="3">            
                                  <!-- {{orders.bids}} -->
                                <div >
                                  <span stlye="font-size:8px"> AMOUNT </span>
                                  <v-row v-for="(order, index) in orders.bids" :key="index">
                                    <v-col cols="12">
                                      <span style="font-size:10px"> {{parseFloat(order[0]).toFixed(2)}} </span>
                                    </v-col>
                                  </v-row> 
                                  <span stlye="font-size:8px"> AMOUNT </span>
                                      <v-row v-for="(order, index) in orders.asks" :key="index">
                                      <v-col cols="12">
                                      <span style="font-size:10px"> {{parseFloat(order[0]).toFixed(2)}} </span>
                            </v-col>
                          </v-row>   
                                </div>
                      </v-col>
                      <v-col cols="3">
                          <div >
                              <span stlye="font-size:8px"> PRICE </span>
                              <v-row v-for="(order, index) in orders.bids" :key="index">
                                <v-col cols="12">
                                  <span style="font-size:10px"> {{parseFloat(order[1]).toFixed(2)}} </span>
                                </v-col>
                              </v-row>  
                              <span stlye="font-size:8px"> PRICE </span>
                              <v-row v-for="(order, index) in orders.asks" :key="index">
                              <v-col cols="12">
                                  <span style="font-size:10px"> {{parseFloat(order[1]).toFixed(2)}} </span>
                        </v-col>
                      </v-row>  
                            </div>
                      </v-col>
                      <!-- <v-col cols="6"></v-col> -->
                      <v-col cols="3">            
                          <!-- {{orders.bids}} -->
                      <div>
                          
                      </div>
              </v-col>
              <v-col cols="3">
                  <div >
                      
                    </div>
              </v-col>
              </v-row>
                  </v-card-text>
                </v-card>
              <v-responsive></v-responsive>
            </v-sheet>
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
          buttonColor: "green",
          sheetColor25: "white",
          sheetColor50: "white",
          sheetColor75: "white",
          sheetColor100: "white",
          buttonLabel: "BUY",
          finalSymbol: '',
          balance: '',
          flat: null,
          buttonOrder: '',
          inputAmount_to_buy: '',
          inputAmount: '',
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
          price: [],
          wallet: [],
          inputAmount: [],
          timer: '',

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
    buyButton()
    
    {
      this.inputAmount = 0
      this.buttonColor = "green"
      this.buttonLabel = "BUY"
      this.sheetColor25 = "white"
      this.sheetColor50 = "white"
      this.sheetColor75 = "white"
      this.sheetColor100 = "white"
      axios.get('/api/v1/wallet-balance', {
        params: {
          'name': 'USDT',
        }
      })
      .then(response => {
        this.wallet = response.data.wallet
      })

    },

    sellButton()
    {
      this.inputAmount = 0
      const symbol = this.btc.symbol
      this.sheetColor25 = "white"
      this.sheetColor50 = "white"
      this.sheetColor75 = "white"
      this.sheetColor100 = "white"
      this.finalSymbol = symbol.replace('USDT', '')
      console.log(this.finalSymbol)
      this.buttonColor = "red"
      this.buttonLabel = "SELL"

      axios.get('/api/v1/wallet-balance', {
        params: {
          'name': this.finalSymbol,
        }
      })
      .then(response => {
        this.wallet = response.data.wallet
      })


    },

    commitOrder()
    {
      var symbol = this.btc.symbol
      this.finalSymbol = symbol.replace('USDT', '')
      console.log(this.finalSymbol)
      axios.post('/api/v1/order', 
      {
        name: this.finalSymbol,
        order_per_unit: this.price,
        number_of_order: this.inputAmount,
        delegate_type: this.buttonLabel,
        balance: this.balance
      })
      .then(response => {
        this.fetchWalletBuy()
        this.fetchOrder()
        this.noChange()
        swal.fire({
          position: "top-end",
          toast: true,
          type: "success",
          text: "Successfully Ordered",
          icon: "success",
          timer: 1500,
          showConfirmButton: false,
                    });
      })
    },

    noChange()
    {
      if(this.buttonLabel == 'BUY')
      {
        console.log("working") 
        this.sheetColor25 = "white"
        this.sheetColor50 = "white"
        this.sheetColor75 = "white"
        this.sheetColor100 = "white"

        this.inputAmount = 0
      }
      else if(this.buttonLabel == 'SELL')
      {
        console.log("working") 
        this.sheetColor25 = "white"
        this.sheetColor50 = "white"
        this.sheetColor75 = "white"
        this.sheetColor100 = "white"

        this.inputAmount = 0

      }
      
        // this.sheetColor = "green"
        
    },
    
    quarterChange()
    {
      if(this.buttonLabel == 'BUY')
      {
        console.log("working") 
        this.sheetColor25 = "green"
        this.sheetColor50 = "white"
        this.sheetColor75 = "white"
        this.sheetColor100 = "white"

        this.inputAmount = (this.wallet.wallet_balance / 4) / this.btc.lastPrice
        this.balance = this.wallet.wallet_balance / 4
      }
      else if(this.buttonLabel == 'SELL')
      {
        console.log("working") 
        this.sheetColor25 = "green"
        this.sheetColor50 = "white"
        this.sheetColor75 = "white"
        this.sheetColor100 = "white"

        this.inputAmount = (this.wallet.wallet_balance / 4) * this.btc.lastPrice
        this.balance = this.wallet.wallet_balance / 4
      }
      
        // this.sheetColor = "green"
        
    },
    halfChange()
    {
      if(this.buttonLabel == 'BUY')
      {
        console.log("working") 
        this.sheetColor25 = "green"
        this.sheetColor50 = "green"
        this.sheetColor75 = "white"
        this.sheetColor100 = "white"

        this.inputAmount = (this.wallet.wallet_balance / 2) / this.btc.lastPrice
        this.balance = this.wallet.wallet_balance / 2
      }
      else if(this.buttonLabel == 'SELL')
      {
        console.log("working") 
        this.sheetColor25 = "green"
        this.sheetColor50 = "green"
        this.sheetColor75 = "white"
        this.sheetColor100 = "white"

        this.inputAmount = (this.wallet.wallet_balance / 2) * this.btc.lastPrice
        this.balance = this.wallet.wallet_balance / 2
      }
        // this.sheetColor = "green"
        
    },
    thirdChange()
    {
      if(this.buttonLabel == 'BUY')
      {
        console.log("working") 
        this.sheetColor25 = "green"
        this.sheetColor50 = "green"
        this.sheetColor75 = "green"
        this.sheetColor100 = "white"
        console.log(this.wallet.wallet_balance)
        console.log(this.btc.lastPrice)
        this.inputAmount = ((this.wallet.wallet_balance / 4) * 3) / this.btc.lastPrice
        this.balance = (this.wallet.wallet_balance / 4) * 3
      }
      else if(this.buttonLabel == 'SELL')
      {
        console.log("working") 
        this.sheetColor25 = "green"
        this.sheetColor50 = "green"
        this.sheetColor75 = "green"
        this.sheetColor100 = "white"
        console.log(this.wallet.wallet_balance)
        console.log(this.btc.lastPrice)
        this.inputAmount = ((this.wallet.wallet_balance / 4) * 3) * this.btc.lastPrice
        this.balance = (this.wallet.wallet_balance / 4) * 3
      }
      
    },
    allInChange()
    {
      if(this.buttonLabel == 'BUY')
      {
        console.log("working") 
        this.sheetColor25 = "green"
        this.sheetColor50 = "green"
        this.sheetColor75 = "green"
        this.sheetColor100 = "green"

        console.log(this.wallet.wallet_balance)
        console.log(this.btc.lastPrice)

        this.inputAmount =this.wallet.wallet_balance / this.btc.lastPrice
        this.balance = this.wallet.wallet_balance
      }
      else if(this.buttonLabel == 'SELL')
      {
        console.log("working") 
        this.sheetColor25 = "green"
        this.sheetColor50 = "green"
        this.sheetColor75 = "green"
        this.sheetColor100 = "green"

        console.log(this.wallet.wallet_balance)
        console.log(this.btc.lastPrice)

        this.inputAmount =this.wallet.wallet_balance * this.btc.lastPrice
        this.balance = this.wallet.wallet_balance 
      }
        // this.sheetColor = "green"
        
    },
    fetchOrder()
    { 
        axios.get('/api/v1/getOrder')
        .then(response => {
                      this.orders = response.data.result
                      this.price = response.data.price
                  })
              .catch(error => {
                  console.log(error);
              })
              .finally(() => {
                 
              });
    },  

    fetchWalletBuy()
    {
      /** if buy select usdt coin else get symbol */
      this.buttonColor = "green"
      this.buttonLabel = "BUY"
      axios.get('/api/v1/wallet-balance', {
        params: {
          'name': 'USDT',
        }
      })
      .then(response => {
        this.wallet = response.data.wallet
      })
    },

    fetchWalletSell()
    {
      /** if buy select usdt coin else get symbol */
      axios.get('/api/v1/wallet-balance', {
        params: {
          'coin_id': 1,
        }
      })
      .then(response => {
        this.wallet = response.data.wallet
      })
    },

    openHome()
      {
        clearInterval(this.timer)
        this.$router.push('/')
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

      fetchMarket() {
          axios
              .get('/api/v1/top-list')
              .then(response => {
                      this.btc = response.data.btc
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

      allowOrder()
      {
        this.inputAmount = this.inputAmount
      }


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
      this.fetchWalletBuy()
      this.fetchOrder()
      this.fetchMarket()
      
      this.timer = setInterval(this.fetchOrder, 3000);

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
