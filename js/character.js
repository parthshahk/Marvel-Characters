Vue.component('character-card', {
    props: ['thumb', 'name'],
    template: "<div class='col xl3 m4 s6 center details-card'><img :src='thumb'><br><span v-html='name' class='grey-text text-darken-3'></span></div>",
});
Vue.component('pre-loader', {
    template: "<div class='preloader-wrapper big active'><div class='spinner-layer spinner-red-only'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div>"
});

new Vue ({
    el: '#character',

    data: {

        state: 'loading',
        id:'',
        charDetails: '',
        description: 'N/A',
        comics: 'notLoaded',
        comicData: '',
        events: 'notLoaded',
        eventsData: '',
        series: 'notLoaded',
        seriesData: ''
    },

    methods: {

        loadComics: function(){
            var self = this;

            axios.get('./api/fetch-marvel.php?id='+this.id+'&type=comics')
            .then(function(response){
                self.comicData = response.data;
                self.comics = 'loaded';
                self.loadEvents();
            })
        },

        loadEvents: function(){
            var self = this;

            axios.get('./api/fetch-marvel.php?id='+this.id+'&type=events')
            .then(function(response){
                self.eventsData = response.data;
                self.events = 'loaded';
                self.loadSeries();
            })
        },

        loadSeries: function(){
            var self = this;

            axios.get('./api/fetch-marvel.php?id='+this.id+'&type=series')
            .then(function(response){
                self.seriesData = response.data;
                self.series = 'loaded';
            })
        }
    },

    created: function(){

        var self = this;

        this.id = window.location.hash.substr(1);
        if(this.id == ''){
            window.location.href = './';
        }

        axios.get('./api/fetch-marvel.php?id='+this.id+'&type=character')
            .then(function(response){
                self.charDetails = response.data;
                if(self.charDetails.description != ''){
                    self.description = self.charDetails.description;
                }
                self.state = 'notLoading';
                self.loadComics();
            })
    }


});