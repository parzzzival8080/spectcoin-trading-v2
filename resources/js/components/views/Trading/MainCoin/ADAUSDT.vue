<template>
  <v-app>
      <v-container>
          <trading-vue :data="this.$data" title-txt="ADAUSDT" :width="width" :height="height"></trading-vue>
      </v-container>
    
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
          this.checkHighLow()
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
          this.width = window.innerWidth - 50,
          this.height = window.innerHeight - 350
          },

          updateChart()
           {

            this.ohlcv.pop()
              
                  axios.get('/api/v1/charts/btcusdt', {
                   
                      params: {
                    symbol: 'ADA'
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
                    symbol: 'ADA'
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