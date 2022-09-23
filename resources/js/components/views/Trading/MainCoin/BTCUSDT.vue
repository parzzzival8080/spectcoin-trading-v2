<template>
    <v-app>
      <v-card>
        <center>
        <v-card-title style="background-color: #9a2491">
         <v-icon style="color:yellow" mr-5>mdi-arrow-left</v-icon> 
          <span style="color:white">BTCUSDT</span> 
        </v-card-title>
      </center>
        <v-card-text>
          <v-row>
            <v-col cols="6">

              <h6>Current Price</h6>
              
              <h6 v-if="chartTick.priceChangePercent > 0" style="color:green">${{(parseFloat(chartTick.lastPrice).toFixed(2))}} <span style="font-size:10px">{{parseFloat(chartTick.priceChangePercent).toFixed(2)}}%</span></h6>
              <h6 v-else="chartTick.priceChangePercent < 0" style="color:red">${{(parseFloat(chartTick.lastPrice).toFixed(2))}} <span style="font-size:10px">{{parseFloat(chartTick.priceChangePercent).toFixed(2)}}%</span></h6>
            </v-col>
           
              <v-col cols="3">
                <span>
                  <span style="font-size:11px">
                    24h High<br/>
                 <span style="font-weight: 600">${{parseFloat(chartTick.highPrice).toFixed(2)}}</span> 
                  </span>
                  
                </span>
              </v-col>
              <v-col cols="3">
                <span>
                  <span style="font-size:11px">
                    24h Vol(BTC)<br/>
                    <span style="font-weight: 600">{{parseFloat(chartTick.volume).toFixed(0)}}</span>
                  </span>
                  
                </span>
              </v-col>
              <v-col cols="6"></v-col>
              <v-col cols="3">
                <span>
                  <span style="font-size:11px">
                    24h Low<br/>
                    <span style="font-weight: 600">${{parseFloat(chartTick.lowPrice).toFixed(2)}}</span>
                  </span>
                  
                </span>
              </v-col>
              <v-col cols="3">
                <span>
                  <span style="font-size:11px">
                    <span style="font-size:9px">24h Vol(USDT)</span><br/>
                    <span style="font-weight: 600">${{parseFloat(chartTick.quoteVolume).toFixed(0)}}</span></span>    
                  </span>
              </v-col>

          </v-row>
            <trading-vue :data="this.$data" title-txt="BTCUSDT" :width="width" :height="height"></trading-vue>
            <v-row style="margin-top:10px">
              <v-col cols="6">
                <v-btn width="100%" color="green" style="color:white">
                  BUY
                </v-btn>
              </v-col>
              <v-col cols="6">
                <v-btn width="100%" color="red" style="color:white">
                  SELL
                </v-btn>
              </v-col>
            </v-row>
            <v-divider></v-divider>
            <h6>About Bitcoin
            </h6>
            <span>Bitcoin is the first successful internet money based on peer-to-peer technology; whereby no central bank or authority is involved in the transaction and production of the Bitcoin currency. It was created by an anonymous individual/group under the name, Satoshi Nakamoto. The source code is available publicly as an open source project, anybody can look at it and be part of the developmental process. Bitcoin is changing the way we see money as we speak. The idea was to produce a means of exchange, independent of any central authority, that could be transferred electronically in a secure, verifiable and immutable way. It is a decentralized peer-to-peer internet currency making mobile payment easy, very low transaction fees, protects your identity, and it works anywhere all the time with no central authority and banks. Bitcoin is designed to have only 21 million BTC ever created, thus making it a deflationary currency.</span>
        </v-card-text>
      </v-card>
    </v-app>
  </template>
  
  <script>
      import axios from 'axios'
import TradingVue from 'trading-vue-js'
      export default {
      components: { TradingVue },
            data() {
            return {
                chartData: [],
                chartTick: [],
                tickDate: [],
                information: [],

                
                width: window.innerWidth,
                height: window.innerHeight,
                
              ticker: '',
              saveCandle: '',
              checkHighLow: '',
              monitor: '',

    
              
              ohlcv: [
                    [ 1663908000000,18925.42, 19550.17,18780.01, 19212.86,356648.41212, 1.519 ],
                    [ 1663908060000,18929.08,19550.17,18780.01,19183.41,356815.49208,	1.344],
                    [1663908120000,18938.42,19550.17,18780.01,19170.07,356845.95609, 1.223]
                    

              ]
            }
          }, 
  
          created()
          {      
                this.ticker = setInterval(this.updateChart, 4000)
                this.checkHighLow = setInterval(this.checkingPrice, 2000)
                this.monitor = setInterval(this.monitorChart, 58000)  
          },

          mounted()
          {
            window.addEventListener('resize', this.onResize)
            this.onResize()
            this.updateChart()
            this.checkingPrice()
            this.monitorChart()
          },
          methods: {
            checkingPrice()
            {
              axios.get('/api/v1/checkHighLow')
              .then(response => {
              })
            },

            monitorChart()
            {
              axios.get('/api/v1/addCandle')
              .then(response => {
                console.log('working')
              })
            },

            onResize(event) {
            this.width = window.innerWidth - 30,
            this.height = window.innerHeight - 350
            },

            updateChart()
             {

              this.ohlcv.pop()
                
                    axios.get('/api/v1/charts/btcusdt', {
                     
                        params: {
                      symbol: 'BTC'
                      }
                    })
                    .then(response => {
                        this.chartData = response.data.chart

                        for (let i = 0; i < this.chartData.length; i++)
                        {
                            this.ohlcv.push(
                               [ 
                              Number(this.chartData[i].date),
                              Number(this.chartData[i].open),
                              Number(this.chartData[i].high),
                              Number(this.chartData[i].low),
                              Number(this.chartData[i].close),
                              Number(this.chartData[i].volume)
                            ]
                            )
                        }
                        
                    }).catch(error => {
                        console.log(error)
                    }).finally(() => {

                    })
   

                // 

                axios.get('/api/v1/btcusdt', {
                  params: {
                      symbol: 'BTC'
                    }
                })
                .then(response => {
                    this.chartTick = response.data.chart
                    const chartData = response.data.chartData
                    const date =  Number(chartData['date']);
                    const open = Number(chartData['open']);
                    const high = chartData['high'];
                    const low = chartData['low'];
                    const close = Number(this.chartTick['lastPrice']);
                    const volume = Number(this.chartTick['volume']);
                    this.ohlcv.push([date, open, high, low, close, volume])                            
                })
            },


           
       
          },

          destroyed() {
              
          }
      }
  </script>