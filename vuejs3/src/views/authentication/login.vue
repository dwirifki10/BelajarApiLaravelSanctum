<template>
    <div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-8">
            <!-- <router-link :to="{name: 'transaction.register'}" class=" text-white btn btn-warning btn-sm rounded shadow mb-3">
                Create New Account
            </router-link> -->

            <div class="card rounded shadow">
                <div class="card header mb-2">
                    <h2 class="text-secondary text-center">Login User</h2>
                </div>
                <div class="card-body">
                    <form @submit.prevent='login()'>
                        <div class="mb-3">
                            <label class="form-label">Username or Email</label>
                            <input type="text" class="form-control" v-model='user.email'>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" v-model='user.password'>
                        </div>
                        <div class="text-danger mb-3" v-if="user.val">
                            username or password is required
                        </div>
                        <button class="btn btn-success">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </div>   
</template>

<script>
import { reactive} from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
    
    export default {
        setup() {
           
            const user = reactive({
                email: '',
                password: '',
                token: localStorage.getItem('token'),
                loggedIn: localStorage.getItem('loggedIn'),
                val: false,
            });

            const router = useRouter();

            function login(){
              if(this.user.email && this.user.password){
                  axios.get('http://localhost:8000/sanctum/csrf-cookie')
                  .then((response)=>{
                      console.log(response)
                      axios.post('http://localhost:8000/api/login', {
                          email: this.user.email,
                          password: this.user.password
                      }).then((result)=>{
                          if(result){
                              localStorage.setItem("token", result.data.token)
                              localStorage.setItem("loggedIn", true);
                              router.push({name: 'transaction.index'})
                          }
                      }).catch((err)=>{
                          user.val = false;
                          alert('your password or username is incorect')
                      })
                    });  // end of then catch
                }else{
                   user.val = true;
                   console.log(user.val)
                }
            }
            

    
            return{
                user, 
                router, 
                login,
            };
        }
    }
</script>
