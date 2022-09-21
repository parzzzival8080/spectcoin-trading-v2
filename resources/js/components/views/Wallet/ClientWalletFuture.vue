<template>
    <v-app>
      <v-card id="outer-card"
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
          <v-btn @click="openFutureTrade()">
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
            <v-btn plain active-class style="margin-top:10px; border-bottom:5px" push @click="openSpot()">Spot</v-btn>
          <v-btn plain active-class style="margin-top:10px;border-bottom:5px" @click="openFuture()">Futures</v-btn>
  

            <v-card id="card-wallet">
                <v-card-title>
                  <v-icon>mdi-wallet</v-icon>
                  <span>Futures Balance</span>
                </v-card-title>
                <v-card-text>
                  <!-- Wallet Balance -->
                  <v-row>
                    <v-divider></v-divider>
                    <div v-for="(wallet, index) in usdtWallet" :key="index">
                      <h2>{{wallet['wallet_balance']}} USDT</h2>
                    </div>
                    
                    
                  </v-row>
                  <v-row justify-center>
                    <v-col cols="4">
                      <v-btn @click="transferRequest">Transfer</v-btn>
                    </v-col>
                  </v-row>
                </v-card-text>
            </v-card>
            
            <v-card id="card-market">
              <v-card-title>
                <v-icon>mdi-building</v-icon>
                <span>Market</span>
              </v-card-title>
              <v-card-text>
                <!-- Wallet Balance -->
                <v-row>
                  <v-col cols="6">
                    <h5 style="font-weight:300">Coin</h5>
                  </v-col>
                  <v-col cols="6">
                    <h5 style="font-weight:300">Balance</h5>
                  </v-col>
                </v-row>
                <div v-for="(wallet, index) in wallets" :key="index">
                  <v-row>
                    <v-col cols="2">
                      <v-img :src="wallet.coin.image" max-width="40px" max-height="40px"></v-img>
                    </v-col>
                    <v-col cols="4">
                      <!-- <v-img  max-height="50" max-width="50" :src="wallet.coin.image"></v-img> -->
                      <span style="font-size:16px;font-weight:600;color:black">{{wallet.coin.name}}
                      </span>
                    </v-col>
                    
                    <v-col cols="6">
                      <!-- <v-img  max-height="50" max-width="50" :src="wallet.coin.image"></v-img> -->
                      <span style="font-size:16px;font-weight:600;color:black">{{parseFloat(wallet.wallet_balance).toFixed(4)}}</span>
                    </v-col>
                    <v-divider></v-divider>
                  </v-row>
                </div>
              </v-card-text>
          </v-card>
          <v-responsive></v-responsive>
        </v-sheet>
        </v-card>
        <v-dialog
            v-model="dialog"
            width="500"
          >
            <v-card>
              <v-card-title class="text-h5 grey lighten-2">
                Transfer
              </v-card-title>
              <v-card-text>
                <v-row style="margin-top:10px">
                  <v-col cols="12">
                    <v-text-field outlined disabled label="FUTURES"></v-text-field>
                    <v-icon>mdi-arrow-down-bold</v-icon><br/><br/>
                    <v-text-field outlined disabled label="SPOTS"></v-text-field>
                    <v-select :items="itemCoins" item-text="name" item-value="id" outlined label="Select Coin" v-model="coin_id"></v-select>
                    
                    <v-row>
                      <v-col cols="12">
  
                        <span v-for="(wallet, index) in usdtWallet" :key="index">Balance:{{wallet['wallet_balance']}} USDT</span>
                      </v-col>
                      <v-col cols="8">
                        
                        <v-text-field outlined v-model="amount" label="Enter Amount"></v-text-field>
                      </v-col>
                      <v-col cols="4"><v-btn x-large style="" @click="transferMax()">Max</v-btn></v-col>
                    </v-row>
                    
                  </v-col>
                  <v-col cols="12">
                    
                  </v-col >
                  <v-col cols="12">
                    
                  </v-col>
                </v-row>
              </v-card-text>
  
              <v-divider></v-divider>
  
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                color="primary"
                text
                @click="transfer()"
              >
                Transfer
              </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
    </v-app>
  </template>
  
  <style>
    #card-wallet
    {
      margin-top:10px;
    }
    #router-card 
    {
      padding: 10px;
    }
    #card-market {
      margin-top: 10px;
     
    }
  </style>
  
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
            coin: [],
            btc: [],
            eth: [],
            xrp: [],
            itemCoins: [],
            ada: [],
            sol: [],
            doge: [],
            polkadot: [],
            shib: [],
            galx: [],
            orders: [],
            price: [],
            wallets: [],
            usdtWallet: [],
            amount: [],
            timer: '',
            dialog: false,
            coin_id: '',
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
  
    methods: {
      fetchMyWallet()
      {
        axios.get('/api/v1/wallets/future')
        .then(response => {
          this.usdtWallet = response.data.usdtWallet
          this.wallets = response.data.wallet
        })
      },
      transferMax()
    {
        
        this.amount = this.usdtWallet[0].wallet_balance

      // console.log(this.usdtWallet[0].wallet_balance)
      // for(const i = 0; i < this.usdtWallet.length; i++)
      // {
      //   console.log(this.usdtWallet)
      // }
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

      openFutureTrade()
      {
        clearInterval(this.timer)
        this.$router.push('/future/orders')
      },

      openWallet()
      {
        clearInterval(this.timer)
        this.$router.push('/wallet/spot')
      },
      fetchCoins() {
            axios
                .get("/api/v1/coins")
                .then(response => {
                    this.itemCoins = response.data.coins;
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.componentOverlay = false;
                    this.tableLoading = false;
                });         
        },
  
      transferRequest()
      {
        this.dialog = true
      },
      openSpot()
    {
      this.$router.push('/wallet/spot')
    },

    openFuture()
    {
      this.$router.push('/wallet/future')
    },

    transfer()
    {
      axios.post('/api/v1/futures/transfer', 
      {
        coin_id: this.coin_id,
        draw_type: 'DRAW_OUT',
        state: 'PENDING',
        transfer_amount: this.amount
      }).then(response => {
        swal.fire({
              position: "top-end",
              toast: true,
              type: "success",
              icon: "success",
              text: "Successfully Transfered",
              showConfirmButton: false,
              timer: 1500
                    });
      })
    },
    },
  
    mounted()
    {
      this.fetchMyWallet()
      this.fetchCoins()
    }
  };
  </script>
  