<template>
    <div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-8">
            <router-link :to="{name: 'transaction.index'}" class=" text-white btn btn-warning btn-sm rounded shadow mb-3">
                Return to Table Transaction
            </router-link>

            <div class="card rounded shadow">
                <div class="card header mb-2">
                    <h2 class="text-secondary text-center">CREATE TRANSACTION DATA</h2>
                </div>
                <div class="card-body">
                    <form @submit.prevent='store()'>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" v-model='transaction.title'>
                            <div class="text-danger" v-if="validation.title">
                                {{ validation.title[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" v-model='transaction.price'>
                            <div class="text-danger" v-if="validation.price">
                                {{ validation.price[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-select" v-model='transaction.type'>
                                <option value="Expensive">Expensive</option>
                                <option value="Cheap">Cheap</option>
                            </select>
                            <div class="text-danger" v-if="validation.type">
                                {{ validation.type[0] }}
                            </div>
                        </div>
                        <button class="btn btn-success">Add Data Transaction</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </div>   
</template>

<script>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
    export default {
        setup() {
           
            const transaction = reactive({
                title: '',
                price: '',
                type: '',
            });

            const validation = ref([]);

            const router = useRouter();

            function store(){
                axios.post('http://localhost:8000/api/transaction', transaction)
                .then(() => {
                    router.push({name: 'transaction.index'});
                }).catch((err) => {
                    validation.value = err.response.data
                });
            }
    
            return{
                transaction, 
                validation,
                router, 
                store,
            };
        }
    }
</script>
