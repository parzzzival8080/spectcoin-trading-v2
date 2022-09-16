<script>
import axios from 'axios';

    export default {
    data() {
        return {
            btc : [],
            eth: [],
            xrp: [],
            ada: [],
            sol: [],
            doge: [],
            polkadot: [],
            shib: [],
            galx: [],
        }
    },
    methods: {
        fetchTopTen()
        {
            axios.get('/api/v1/fetch-top-ten')
            .then((response) => {
                this.btc = response.data.btc
                this.eth = response.data.eth
                this.xrp = response.data.xrp
                this.ada = response.data.ada
                this.sol = response.data.sol
                this.doge = response.data.doge
                this.polkadot = response.data.polkadot
                this.shib = response.data.shib
                this.galx = response.data.galx
            })
        }, 

         
    }
};
</script>
