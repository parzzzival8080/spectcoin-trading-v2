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
                        <v-spacer></v-spacer>
                        <v-icon>mdi-chart-waterfall</v-icon>
                        <v-icon>mdi-format-list-bulleted</v-icon>
                      <v-row > 
                                          
                        <v-col cols="6">
                            <v-btn style="margin-right:5px;background-color:green; color:white" @click="buyButton()">Buy Long</v-btn>
                            <v-btn style="background-color:red; color:white" @click="sellButton()">Sell Short</v-btn>
                            <v-text-field style="color:white" placeholder="AMOUNT ORDER" :value="parseFloat(btc.lastPrice).toFixed(4)"></v-text-field>
                            <v-text-field style="color:white" placeholder="Amount" :value="amount"></v-text-field>
                            <v-text-field style="color:white" placeholder="Leverage" v-model="leverage"></v-text-field>
                            <v-btn :color="buttonColor" style="width:100%; color:white" @click="commitOrder()">{{buttonLabel}}</v-btn>
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
                <v-card>
                  <v-card-title>
                    <v-row>
                      <v-col cols="6">BTCUSDT<br/>
                        <v-span style="font-size:12px">Income Rate: {{margin.rate_of_return}} %</v-span> 
                      </v-col>
                      <v-col cols="6"><v-btn>Close Position</v-btn></v-col>
                    </v-row>
                     <br/>
                  </v-card-title>
                  <v-card-text>
                    <v-row>
                     <v-col cols="6">
                        <span style="font-size:15px; font-weight:600">Opening Interest</span>
                     </v-col>
                     <v-col cols="6">
                      <span style="font-size:15px; font-weight:600">{{margin.open_interest}}</span>
                     </v-col>
                     <v-col cols="6">
                      <span style="font-size:15px; font-weight:600">Entry Price</span>
                        </v-col>
                        <v-col cols="6">
                          <span style="font-size:15px; font-weight:600">{{margin.opening_price}}</span>
                        </v-col>
                        <v-col cols="6">
                          <span style="font-size:15px; font-weight:600">Income(USDT)</span>
                      </v-col>
                      <v-col cols="6">
                        <span style="font-size:15px; font-weight:600">{{margin.income}}</span>
                      </v-col>
                      <v-col cols="6">
                        <span style="font-size:15px; font-weight:600">Accessible Volume</span>
                    </v-col>
                    <v-col cols="6">
                      <span style="font-size:15px; font-weight:600"></span>
                    </v-col>
                        <v-col cols="6">
                          <span style="font-size:15px; font-weight:600">Current Price</span>
                      </v-col>
                      <v-col cols="6">
                        <span style="font-size:15px; font-weight:600">{{margin.current_price}}</span>
                      </v-col>
                      <v-col cols="6">
                        <span style="font-size:15px; font-weight:600">Margin(USDT)</span>
                    </v-col>
                    <v-col cols="6">
                      <span style="font-size:15px; font-weight:600">{{margin.margin}}</span>
                    </v-col>
                      <v-col cols="6">
                        <span style="font-size:15px; font-weight:600">Leverage(Multiple)</span>
                    </v-col>
                    <v-col cols="6">
                      <span style="font-size:15px; font-weight:600">X{{margin.leverage}}</span>
                    </v-col>
                    <v-col cols="6">
                      <span style="font-size:15px; font-weight:600">Remaining Time of Contract</span>
                   </v-col>
                   <v-col cols="6">
                    <span style="font-size:15px; font-weight:600">Coming Soon</span>
                  </v-col>
                    </v-row>


                  </v-card-text>
                </v-card>
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
            buttonColor: "green",
            sheetColor25: "white",
            sheetColor50: "white",
            sheetColor75: "white",
            sheetColor100: "white",
            buttonLabel: "BUY",
            finalSymbol: '',
            balance: '',
            flat: null,
            amount_to_buy: '',
            leverage: '',
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
            amount: [],
            margin: [],
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
        this.amount = 0
        this.buttonColor = "green"
        this.buttonLabel = "BUY"
        this.sheetColor25 = "white"
        this.sheetColor50 = "white"
        this.sheetColor75 = "white"
        this.sheetColor100 = "white"
        axios.get('/api/v1/future/wallet-balance', {
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
        this.amount = 0
        const symbol = this.btc.symbol
        this.sheetColor25 = "white"
        this.sheetColor50 = "white"
        this.sheetColor75 = "white"
        this.sheetColor100 = "white"
        this.finalSymbol = symbol.replace('USDT', '')
        console.log(this.finalSymbol)
        this.buttonColor = "red"
        this.buttonLabel = "SELL"
  
        axios.get('/api/v1/future/wallet-balance', {
          params: {
            'name': this.finalSymbol,
          }
        })
        .then(response => {
          this.wallet = response.data.wallet
        })
  
  
      },

      fetchFuture()
      {
        axios.get('/api/v1/margin')
        .then(response => {
          this.margin = response.data.margin
        })
      },
  
      commitOrder()
      {
        var symbol = this.btc.symbol
        this.finalSymbol = symbol.replace('USDT', '')
        console.log(this.finalSymbol)
        axios.post('/api/v1/futures/order', 
        {
          name: this.finalSymbol,
          opening_price: this.price,
          margin: this.amount,
          leverage: this.leverage,
          delegate_type: this.buttonLabel
        })
        .then(response => {
          
        })
      },
      
      order()
      {
        const userRole = sessionStorage.getItem('user-type')
          if(userRole == null)
          {
            this.$router.push('/login')
          }
          else{ 
            console.log('working')
          }
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
  
          this.amount = (this.wallet.wallet_balance / 4)
        }
        else if(this.buttonLabel == 'SELL')
        {
          console.log("working") 
          this.sheetColor25 = "green"
          this.sheetColor50 = "white"
          this.sheetColor75 = "white"
          this.sheetColor100 = "white"
  
          this.amount = (this.wallet.wallet_balance / 4)
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
  
          this.amount = (this.wallet.wallet_balance / 2) / this.btc.lastPrice
          this.balance = this.wallet.wallet_balance / 2
        }
        else if(this.buttonLabel == 'SELL')
        {
          console.log("working") 
          this.sheetColor25 = "green"
          this.sheetColor50 = "green"
          this.sheetColor75 = "white"
          this.sheetColor100 = "white"
  
          this.amount = (this.wallet.wallet_balance / 2)
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
          this.amount = ((this.wallet.wallet_balance / 4) * 3) 
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
          this.amount = ((this.wallet.wallet_balance / 4) * 3) 
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
  
          this.amount =this.wallet.wallet_balance 
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
  
          this.amount =this.wallet.wallet_balance * this.btc.lastPrice
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
        this.buyButton()
        this.fetchOrder()
        this.fetchMarket()
        this.fetchFuture()
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
  