<template>
    <div class="row">
                    
        <div class="col-12 col-sm-6 col-lg-4" 
            v-match-heights="{
                el: ['h5.sub-title'],  // Array of selectors to fix
            }"
            v-for="(venue, index) in venues" 
            :key="index"
        >
            
            <div class="lgx-event">
                <a :href="venueSlug(venue.slug)">
                    <div class="lgx-event__image">
                        <img  :src="'/storage/'+JSON.parse(venue.images)[0]" alt="">
                    </div>
                    <div class="lgx-event__info">
                        
                        <div class="meta-wrapper">
                            
                            <span> {{ venue.city }}</span>
                            <span >{{ venue.state}} </span>
                            <span v-if="venue.country != null"> {{ venue.country.country_name }}</span>
                        </div>
                        
                        <h3 class="title">{{ venue.title }}</h3>
                    </div>

                </a>
            </div>
        
            
        </div>

        <div class="col-12" v-if="not_found">
            <h4 class="heading text-center mt-30"><i class="fas fa-exclamation-triangle"></i> {{ trans('em.venues_not_found') }}</h4>
        </div>
        
    </div>
</template>

<script>

import mixinsFilters from '../../mixins.js';

export default {
    
    props: ['venues', 'currency', 'date_format'],

    mixins:[
        mixinsFilters
    ],

    data() {
        return {
            not_found: false,
        }
    },

    methods:{
        
        
        // return route with venue slug
        venueSlug: function venueSlug(slug) {
            return route('eventmie.venues.show',[slug]);
        }

  
    },

    watch: {
        venues: function () {
            this.not_found = false;
            if(this.venues.length <= 0)
                this.not_found = true;
        },
    },

    

}
</script>