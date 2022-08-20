<!-- parent component-->
<template>
    <div class="container">
        
        <Venue-component 
            :organiser_id="organiser_id"
        >
        </Venue-component>

        <div class="row">
            <div class="col-md-12 table-responsive table-mobile">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('em.title') }}</th>
                            <th>{{ trans('em.venue_type') }}</th>
                            <th>{{ trans('em.state') }}</th>
                            <th>{{ trans('em.city') }}</th>
                            <th>{{ trans('em.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="active"  v-for="(item, index) in venues"
                            v-bind:item="item"
                            v-bind:index="index"
                            v-bind:key="item.id" 
                        >
                            <td :data-title="trans('em.title')">{{ item.title }}</td>
                            <td :data-title="trans('em.venue_type')">{{ item.venue_type }}</td>
                            <td :data-title="trans('em.state')">{{ item.state }}</td>
                            <td :data-title="trans('em.city')">{{ item.city }}</td>
                            <td :data-title="trans('em.actions')"> 
                                <div class="btn-group">
                                    <button type="button" class="btn lgx-btn lgx-btn-sm" @click="edit_index = index"><i class="fas fa-edit"></i> {{ trans('em.edit') }}</button>
                                    <button type="button" class="btn lgx-btn lgx-btn-sm lgx-btn-danger" @click="deleteVenue(item.id)"><i class="fas fa-trash"></i> {{ trans('em.delete') }}</button>
                                </div>
                                <Venue-component  v-if="edit_index == index" :edit_venue="item" :organiser_id="organiser_id" ></Venue-component>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
        <div class="row" v-if="venues.length > 0">
            <div class="col-md-12 text-center">
                <pagination-component v-if="pagination.last_page > 1" :pagination="pagination" :offset="pagination.total" :path="'/myveneus'" @paginate="getVenues()">
                </pagination-component>
            </div>
        </div>
    </div>
</template>

<script>

import VenueComponent from './Venue.vue';
import PaginationComponent from '../../common_components/Pagination';
import mixinsFilters from '../../mixins.js';
import MapAutocomplete from './MapAutocomplete.vue';

export default {
    props: [
        'organiser_id', 'page',
    ],

    components: {
        VenueComponent,
        PaginationComponent,
        MapAutocomplete
    },

    mixins:[
        mixinsFilters
    ],

    data() {
        return {
            venues       : [],
            edit_index : null,
            pagination : {
                'current_page': 1
            },
        }
    },
    computed: {
         
        current_page() {
            // get page from route
            if(typeof this.page === "undefined")
                return 1;
            return this.page;
        },
    },
    methods: {
        getVenues() {
            axios.get(route('eventmie.myvenues.index')+'?page='+this.current_page+'&organiser_id='+this.organiser_id)
            .then(res => {
                console.log('hello world', res.data.venues.data);
                // fill data venues array
                this.venues   = res.data.venues.data;
                this.pagination = {
                    'total' : res.data.venues.total,
                    'per_page' : res.data.venues.per_page,
                    'current_page' : res.data.venues.current_page,
                    'last_page' : res.data.venues.last_page,
                    'from' : res.data.venues.from,
                    'to' : res.data.venues.to
                };
            })
            .catch(error => {
                Vue.helpers.axiosErrors(error);
            });
        },
        deleteVenue(venue_id){

            this.showConfirm(trans('em.delete_venue_ask')).then((res) => {
                if(res) {
         
                    axios.post(route('eventmie.myvenues.destroy',[venue_id]), {
                        
                        // headers: {
                        //     _method : 'DELETE'
                        // },

                        organiser_id : this.organiser_id,
                        _method      : 'DELETE'
                    })
                    .then(res => {
                    
                        if(res.data.status)
                        {
                            this.getVenues();
                            this.showNotification('success', trans('em.delete_venue_succcess'));
                        }
                    })
                    .catch(error => {
                        Vue.helpers.axiosErrors(error);
                    });
                }
            })
        }
    },


    mounted() {
        this.getVenues();
    }
}
</script>

