Vue.component('pre-loader', {
    template: "<div class='preloader-wrapper big active'><div class='spinner-layer spinner-red-only'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div>"
});

new Vue ({
    el: '#character',

    data: {

        state: 'loading',
        id:'',
        charDetails: '',
        description: 'N/A'
    },

    methods: {

        
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
            })
    }


});