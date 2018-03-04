<template>
	<div class="login-modal" role="dialog">
		<div class="login-choose row">
			<div class="col-xs-6 center login-tab" :class="tabs.login" @click="toggleTab('login')">Вход</div>
			<div class="col-xs-6 center register-tab" :class="tabs.register" @click="toggleTab('register')">Регистрация</div>
		</div>
		<div class="clear"></div>
		<div class="login-block padding" :class="tabs.login">
			<div class="login-form">
				<h2 class="center">Вход в аккаунт</h2>
				<div class="input-field">
		        	<input type="text" id="login-email" placeholder="Email" v-model="loginFields.email">
				</div>
				<div class="input-field">
		        	<input type="password" id="login-pass" placeholder="Пароль" v-model="loginFields.password">
		        </div>
		        <button @click="loginUser()" @keyup.enter="loginUser()" class="button primary block center">Войти</button>
			</div>
		</div>
		<div class="register-block padding" :class="tabs.register">
			<h2 class="center">Регистрация</h2>
			<div class="input-field">
	        	<input type="text" id="register-name" placeholder="Имя" v-model="registerFields.name">
			</div>
			<div class="input-field">
	        	<input type="text" id="register-email" placeholder="Email" v-model="registerFields.email">
			</div>
			<div class="input-field">
	        	<input type="password" id="register-pass" placeholder="Пароль" v-model="registerFields.password">
	        </div>
	        <div class="input-field">
	        	<input type="text" id="register-coupon" placeholder="Купон" v-model="registerFields.coupon">
			</div>
	        <button @click="createUser()" @keyup.enter="createUser()" class="button primary block center">Зарегистрироваться</button>
		</div>
	</div>
</template>

<script type="text/javascript">
	import { mapGetters } from 'vuex'
	import { mapActions } from 'vuex'

	export default {
		data() {
			return {
				loginFields: {
					email: '',
					password: '',
				},
				registerFields: {
					email: '',
					password: '',
					name: '',
					coupon: '',
				},
				tabs: {
					login: {
						'active': true
					},
					register: {
						'active': false
					}
				}
			}
		},
		methods: {
			...mapActions({
				login: 'user/login',
				create: 'user/create'
			}),
			toggleTab(tab) {
				for(let i in this.tabs) {
					i == tab ? this.tabs[i]['active'] = true : this.tabs[i]['active'] = false
				}
			},
			loginUser() {
				let _self = this;

				this.$snotify.async(
					'Пожалуйста ожидайте',
					'Авторизация',
					() => new Promise((resolve, reject) => {
			      _self.login(_self.loginFields)
							.then((response) => {
								resolve({
					        title: 'Успешно!',
					        body: 'Здравствуйте, ' + response.data.user.name + '!',
					        config: {
					          closeOnClick: true,
					          timeout: 2000
					        }
					      })
					    })
					    .catch((e) => {
					    	reject({
					        title: 'Ошибка!',
					        body: 'Проверьте правильность полей',
					        config: {
					          closeOnClick: true,
					          timeout: 3000
					        }
					      })
					    })
			  	})
		  	)

			},
			createUser() {
				let _self = this;

				this.$snotify.async(
					'Пожалуйста ожидайте',
					'Авторизация',
					() => new Promise((resolve, reject) => {
			      _self.create(_self.registerFields)
							.then((response) => {
								resolve({
					        title: 'Успешно!',
					        body: 'Здравствуйте, ' + response.data.user.name + '!',
					        config: {
					          closeOnClick: true,
					          timeout: 2000
				        	}
					      })
					    })
					    .catch((e) => {
					    	let error = '';
					    	if (e.data && e.data.errors) {
					    		for (let i in e.data.errors) {
					    			error += e.data.errors[i] + '\n\t';
					    		}
					    	} else {
					    		error = 'Проверьте правильность полей';
					    	}
					    	reject({
					        title: 'Ошибка!',
					        body: error,
					        config: {
					          closeOnClick: true,
					          // timeout: 3000
					        }
					      })
					    })
			  	})
		  	)
		  	
				
			}
		},
		computed: {
			...mapGetters({
				userData: 'user/userData'
			})
		},
		watch: {
			'userData': {
				handler: function() {
					console.log(this.userData)
				}
			}
		}
	}
</script>