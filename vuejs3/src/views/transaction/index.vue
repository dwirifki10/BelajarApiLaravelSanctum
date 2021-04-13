<template>
 <div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-8">
            <button class="btn btn-danger btn-sm rounded mb-3">Log Out</button>
            <br>
            <router-link :to="{name: 'transaction.create'}" class="btn btn-primary btn-sm rounded shadow mb-3">
                Add Data
            </router-link>
            <div class="card rounded shadow">
                <div class="card header mb-2">
                    <h2 class="text-secondary text-center">TRANSACTION DATA</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">Title</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(transaction, index) in transaction.data" :key="index">
                                <td class="text-center">{{transaction.title}}</td>
                                <td class="text-center">{{transaction.price}}</td>
                                <td class="text-center">{{transaction.type}}</td>
                                <td class="text-center">  
                                    <router-link :to="{name: 'transaction.edit', params:{id: transaction.id}}" class="btn btn-sm btn-primary"> Edit Data </router-link>
                                    ||
                                    <button class="btn btn-sm btn-danger" @click.prevent="deletedData(transaction.id, index)"> Delete Data </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
 </div>   
</template>

<script>
import axios from "axios"
import {useRouter} from 'vue-router'
import {onMounted, ref, reactive, onBeforeMount} from "vue"
    
    export default {
        setup(){

            let user = reactive({
                token: localStorage.getItem('token'),
                loggedIn: localStorage.getItem('loggedIn'),
            })

            let transaction = ref([]);

            const router = useRouter();

            onBeforeMount(()=>{
                if(!user.loggedIn){
                    router.push({name: 'authentication.login'});
                }
            })

            onMounted(() => {
                axios.get('http://localhost:8000/api/transaction', {headers: {'Authorization': 'Bearer ' + user.token}})
                .then((result) =>{
                    transaction.value = result.data
                }).catch((err) =>{
                    console.log(err.response);
                });
            });

            function deletedData(id, index){
                if(confirm("are you sure ?")){
                    axios.delete('http://localhost:8000/api/transaction/' + id)
                    .then(() =>{
                        transaction.value.data.splice(index, 1);
                    }).catch((err) =>{
                        console.log(err.response.data);
                    });
                }
            }
        
            return {
                transaction,
                deletedData,
                router,
            }

        }

    }
</script>
