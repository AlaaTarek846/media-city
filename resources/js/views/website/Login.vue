<template>

     <section class="py-5">
        <div class="container px-3">
           <div class="row g-4 g-lg-5 align-items-center">
             <div class="col-12 col-xl-6">
               <div class="auth-register p-4 p-sm-5 rounded-3 border">
                  <h4 class="mb-0">{{$t('auth.signIn')}}</h4>
                  <p>{{$t('auth.Dont have an account?')}} <a href="/register" class="text-decoration-underline link-body-emphasis">{{ $t('auth.SignUp') }}</a></p>
                  <div class="form-body mt-5">
                    <div class="row row-cols-1 g-3">
                        <div class="bg-danger-transparent p-2 text-danger" v-show="errors">{{ errors?.message || '' }}</div>
                        <form @submit.prevent="userLogin(loginData.data)">
                       <div class="col">
                          <label for="EmailAddress" class="form-label">{{$t('label.emailOrPhone')}}</label>
                          <input type="text" class="form-control form-control-lg border-2" v-model="loginData.data.email" id="EmailAddress" :placeholder="$t('label.emailOrPhone')">
                       </div>
                       <div class="col">
                        <label class="form-label">{{$t('label.password')}}</label>
                        <div class="input-group" id="show_hide_password">
                          <input type="password" class="form-control form-control-lg border-end-0"  v-model="loginData.data.password" id="inputChoosePassword" :placeholder="$t('label.password')">
                          <a href="javascript:;" @click="showPassword" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                        </div>
                      </div>
                      <!-- <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                            <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                        </div>
                      </div>
                      <div class="col-md-6 text-end"><a href="auth-forgot-password.html" class="text-decoration-underline link-body-emphasis">Forgot Password ?</a></div> -->
                      <div class="col mt-3">
                        <div class="d-grid">
                            <button class="btn btn-dark btn-lg px-4 rounded-3" type="submit" v-if="!loading">{{$t('auth.signIn')}}</button>
                            <button class="btn btn-dark btn-lg px-4 rounded-3" type="submit" v-else disabled style="cursor: not-allowed;">{{$t('auth.Loading')}}</button>
                        </div>
                      </div>
                      </form>
                      <!-- <div class="col">
                        <div class="separator section-padding mt-4">
                          <div class="line"></div>
                          <p class="mb-0">OR SIGN IN WITH</p>
                          <div class="line"></div>
                        </div>
                      </div> -->
                      <!-- <div class="col">
                        <div class="d-flex flex-column flex-lg-row align-items-center gap-2">
                           <button type="button" class="btn btn-outline-dark w-100 border border-2 flex-fill d-flex align-items-center gap-2 justify-content-center"><i class="bi bi-facebook"></i>Facebook</button>
                           <button type="button" class="btn btn-outline-dark w-100 border border-2 flex-fill d-flex align-items-center gap-2 justify-content-center"><i class="bi bi-twitter-x"></i>Twitter</button>
                           <button type="button" class="btn btn-outline-dark w-100 border border-2 flex-fill d-flex align-items-center gap-2 justify-content-center"><i class="bi bi-apple"></i>Apple</button>
                        </div>
                      </div> -->
                    </div><!--end row-->
                  </div>
               </div>
             </div>
             <div class="col-12 col-xl-6 d-none d-xl-flex">
               <div class="auth-register-img">
                  <img src="/website/images/gallery/auth/login.png" class="img-fluid" width="650" alt="">
               </div>
             </div>
           </div><!--end row-->
        </div>
    </section>

</template>

<script setup>
    import webApi from "../../api/webAxios";

    import { reactive,ref} from "vue";
    const errors = ref(null);
    const loading = ref(false);
    const eye = ref('fa fa-eye')

    //start design
    let loginData =  reactive({
        data:{
            email:'',
            password:'',
        }
    });
    const userLogin = async (data) => {
        loading.value=true
        errors.value='';
        await webApi.post('/web/login',data).then((result)=>{
            let l = result.data.data;
            errors.value = null;
            if(result.data.data){
               
                window.location.href = '/';
            }
        }).catch((e) => {
            if(e.response.status == 403){
                Swal.fire({
                    icon: 'error',
                    title: `${t('global.ThisAccountIsSuspendedPleaseReturnToSupport')}`,
                });
            }
            if(e.response.status == 402){
                Swal.fire({
                    icon: 'error',
                    title: e.response.data.message,
                });
            }else {
                errors.value = e.response.data
                setTimeout(() => errors.value = null,4000);
            }

            loading.value=false
        })
        loading.value=false
    }
    const showPassword = async () => {
      var x = document.getElementById("show_hide_password");
       if ($('#show_hide_password input').attr("type") == "text") {
          $('#show_hide_password input').attr('type', 'password');
          $('#show_hide_password i').addClass("bi-eye-slash-fill");
          $('#show_hide_password i').removeClass("bi-eye-fill");
        } else if ($('#show_hide_password input').attr("type") == "password") {
          $('#show_hide_password input').attr('type', 'text');
          $('#show_hide_password i').removeClass("bi-eye-slash-fill");
          $('#show_hide_password i').addClass("bi-eye-fill");
        }
    };

</script>

<style scoped>
</style>
