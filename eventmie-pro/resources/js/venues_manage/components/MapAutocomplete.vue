<template>
     <div>
        <div class="form-group">
            <label for="venue">Google {{ trans('em.search_location') }}</label>
            <vue-google-autocomplete
                ref="address"
                id="map"
                classname="form-control"
                :placeholder="'Google '+ trans('em.venue')"
                v-on:placechanged="getAddressData"
                country=""
            >
            </vue-google-autocomplete>
        </div>    
    </div>  
</template>
 
<script>
    
    import VueGoogleAutocomplete from 'vue-google-autocomplete'
    
    export default {
        components: { VueGoogleAutocomplete },
 
        data: function () {
            return {
              
              
            }
        },
 
        mounted() {
            // To demonstrate functionality of exposed component functions
            // Here we make focus on the user input
            this.$refs.address.focus();
        },
 
        methods: {
            
            getAddressData: function (addressData, placeResultData, id) {
                var place   = [];
                var place   = addressData;
                place['formatted_address'] = placeResultData.formatted_address;
                console.log(place);
                this.setFields(place)
            },

            // set fields 
            setFields(place = null){
                var _this              = this;
                var country_name       = place.country;
                this.$parent.venue     = place.route;
                this.$parent.city      = place.locality;
                this.$parent.zipcode   = place.postal_code;
                this.$parent.state     = place.administrative_area_level_1;
                this.$parent.address   = place.formatted_address;
                this.$parent.glat      = place.latitude;
                this.$parent.glong     = place.longitude;
                // selcet county
                // this.$parent.countries.forEach(function(value, key){
                //     if(value.country_name == country_name)
                //         _this.$parent.country_id = value.id;  
                // });
            }


            
            
        }
    }
</script> 