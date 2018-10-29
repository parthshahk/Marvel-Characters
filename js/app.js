Vue.component('character-card', {
    props: ['thumb', 'name', 'id'],
    methods: {
        charPage: function(id){
            window.location.href = './character.html#'+id;
        }
    },
    template: "<div class='col xl4 m6 s12 center character-card' @click='charPage(id)'><img :src='thumb'><br><span v-html='name' class='grey-text text-darken-3'></span></div>",
});

Vue.component('pre-loader', {
    template: "<div class='preloader-wrapper big active'><div class='spinner-layer spinner-red-only'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div>"
});

new Vue({
    el: '#app',

    data: {
        state: 'loading',
        random: '',
        searchData: '',
        searchQ: '',
        randomCount: 20,
        alphabets: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', '<br>', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']
    },

    methods: {

        searchCharacter: function(){

            this.state = 'loading';
            var self = this;

            if(self.searchQ == ''){

                axios.get('./api/fetch-local.php?type=random&q='+self.randomCount)
                    .then(function (response){
                        self.random = response.data;
                        self.state = 'landingPage';
                    })

            }else{

                axios.get('./api/fetch-local.php?type=like&q='+self.searchQ)
                    .then(function(response){
                        self.searchData = response.data;
                        self.random = '';
                        self.state = 'searchPage';
                    })
            }   
        },


        searchAlpha: function(a){

            this.state = 'loading';
            var self = this;

            axios.get('./api/fetch-local.php?type=alphabet&q='+a)
                .then(function(response){
                    self.searchData = response.data;
                    self.random = '';
                    self.state = 'searchPage';
                })
        }



    },

    created: function(){
        var self = this;

        axios.get('./api/fetch-local.php?type=random&q='+self.randomCount)
            .then(function (response){
                self.random = response.data;
                self.state = 'landingPage';
            })
    }




});