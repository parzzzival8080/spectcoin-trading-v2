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
  
            <v-card id="card-wallet">
                <v-icon style="margin-left:2px" @click="$router.go(-1)">mdi-arrow-left</v-icon>Back
                <v-card-title>
                  <v-icon>mdi-wallet</v-icon>
                  <span>Deposit</span>
                </v-card-title>
                <v-card-text>
                  <!-- Wallet Balance -->
                  <v-row>
                    <v-divider></v-divider>
                    
                    <v-select outlined label="Select Coin" v-model="coin"></v-select>                    
                    <v-select outlined label="Select Network" v-model="transfer"></v-select> 
                  </v-row>
                  <v-row>
                    <span>Address</span><br/>
                    <span style="font-weight:600">TG9ty3UQKLje8DvL2eGuGR7cxB5VbJPvxy</span>
              </v-row>
                  <v-row>
                    <v-col cols="6">
                        <span>Expected Arrival</span><br/>
                        <span style="font-weight:600">1 network confirmations</span>
                    </v-col>
                    <v-col cols="6">
                        <span>Expected Arrival</span><br/>
                        <span style="font-weight:600">1 network confirmations</span>
                    </v-col>
                    <v-col cols="6">
                        <span>Minimum deposit</span><br/>
                        <span style="font-weight:600">0.00000001 USDT</span>
                    </v-col>
                  </v-row>
                  <v-row>
                    <ul>
                        <li>Send only USDT to this deposit address.</li>
                        <li>Ensure the network is <span style="color:red">Tron (TRC20)</span>.</li>
                    </ul>
                  </v-row>
                </v-card-text>
            </v-card>
        
        </v-card>
    </v-app>
  </template>
  
  <style>
    #card-wallet
    {
      margin-top:10px;
    }
    #outer-card 
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
  
    // methods: {
    //   fetchMyWallet()
    //   {
  
    //   },
    // }
  };
  </script>
  