<template>
    <v-app>
      <trading-vue :data="this.$data" title-txt="BTCUSD"></trading-vue>
    </v-app>
  </template>
  
  <script>
      import TradingVue from 'trading-vue-js'
      export default {
      components: { TradingVue },
            data() {
            return {
              chartData: [],
              chartTick: [],
                
              ticker: '',
              saveCandle: '',
              ohlcv: [
                  [ 1636560000000, 33,  37.1, 14,  14,  196 ],
                  [ 1636563600000, 13.7, 30, 6.6,  30,  206 ],
              ]
            }
          }, 
  
          created()
          {
                this.ticker = setInterval(this.updateChart, 1000)
                this.refresh = setInterval(this.addChart, 55000)
           
          },
          methods: {
            updateChart()
            {
              this.ohlcv.pop()
              axios
                  .get("/api/v1/chart", {
                      params: {
                          coin_pair_id: 1
                      }
                  })
                  .then(response => {
                      this.chartData = response.data.chart;
                      
                      for(let i = 0; i < this.chartData.length; i++)
                      {
                          this.ohlcv.push(
                            [Number(this.chartData[i].date), 
                            Number(this.chartData[i].open), 
                            Number(this.chartData[i].high),
                            Number(this.chartData[i].low), 
                            Number(this.chartData[i].close), 
                            Number(this.chartData[i].volume)]
                        )
                      }
                        
                      // }
                      
                  })
                  .catch(error => {
                      console.log(error);
                  })
                  .finally(() => {
                    
                  });
  
                  axios
                  .get("/api/v1/latest-candle", {
                      params: {
                          coin_pair_id: 1
                      }
                  })
                  .then(response => {
                      this.chartTick = response.data.chart;
                      const date = this.chartTick.date
                      const high = this.chartTick.high;
                      const volume = this.chartTick.volume;
                      const min_close = this.chartTick.price_range_from;
                      const max_close = this.chartTick.price_range_to;
                      const open = this.chartTick.open;
                      const low = this.chartTick.low;
                      // const max_low = 40;
                      // const low = 10;
                      
                      const close = Math.floor(Math.random()*(max_close-min_close+1)+min_close);        
                      if(close > high)
                      {
                              axios
                              .get("/api/v1/latest-candle/update", {
                                params: {
                                  id: this.chartTick.id,
                                  date: date,
                                  open: open,
                                  high: close,
                                  low: low,
                                  close: close,
                                  volume: volume,
                                }
                              })
                              .then(response => {
                              })
                              .catch(error => {
                                  console.log(error);
                              })
                              .finally(() => {
                                
                              });
  
                              
                      }
                      else if(close < low)
                      {
                        axios
                              .get("/api/v1/latest-candle/update", {
                                params: {
                                  id: this.chartTick.id,
                                  date: date,
                                  open: open,
                                  high: high,
                                  low: close,
                                  close: close,
                                  volume: volume,
                                }
                              })
                              .then(response => {
                              })
                              .catch(error => {
                                  console.log(error);
                              })
                              .finally(() => {
                                
                              });
                      }
                      else {
                        axios
                              .get("/api/v1/latest-candle/update", {
                                params: {
                                  id: this.chartTick.id,
                                  date: date,
                                  open: open,
                                  high: high,
                                  low: low,
                                  close: close,
                                  volume: volume,
                                }
                              })
                              .then(response => {
                              })
                              .catch(error => {
                                  console.log(error);
                              })
                              .finally(() => {
                                
                              });
                      }                            
                      
                  })
                  .catch(error => {
                      console.log(error);
                  })
                  .finally(() => {
            
                  });
                
            },
  
            addChart()
            { 
              axios
                  .get("/api/v1/latest-candle", {
                      params: {
                          coin_pair_id: 1
                      }
                  })
                  .then(response => {
                      this.chartTick = response.data.chart;
                      const date = this.chartTick.date
                      const high = this.chartTick.high;
                      const volume = this.chartTick.volume;
                      const min_close = this.chartTick.price_range_from;
                      const max_close = this.chartTick.price_range_to;
                      const open = this.chartTick.open;
                      const low = this.chartTick.low;
                      const close = this.chartTick.close;
                      // const max_low = 40;
                      // const low = 10;
  
                      const new_close = Math.floor(Math.random()*(max_close-min_close+1)+min_close);
  
                        axios
                              .post("/api/v1/latest-candle/add", {
                                  id: this.chartTick.id,
                                  coin_pair_id: this.chartTick.coin_pair_id,
                                  date: Number(date) + 3600000,
                                  open: close,
                                  high: close,
                                  low: close,
                                  close: close,
                                  volume: volume,
                                  price_range_from: min_close,
                                  price_range_to: max_close,
                              })
                              .then(response => {
                              })
                              .catch(error => {
                                  console.log(error);
                              })
                              .finally(() => {
                                
                              });                            
                  })
                  .catch(error => {
                      console.log(error);
                  })
                  .finally(() => {
            
                  });
            },

            setIntervals()
            {
                
            }
          },
      }
  </script>