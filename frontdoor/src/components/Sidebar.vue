<template>
	<aside :class="{ 'is-expanded': is_expanded }">
	  <div class="logo">
		<img :src="logoURL" alt="Vue" />
	  </div>
  
	  <div class="menu-toggle-wrap">
		<button class="menu-toggle" @click="toggleMenu">
		  <span class="material-icons">keyboard_double_arrow_right</span>
		</button>
	  </div>
  
	  <h3>Menu</h3>
	  <div class="menu">
		<router-link to="/" class="button">
		  <span class="material-icons">incomplete_circle</span>
		  <span class="text">Dashboard</span>
		</router-link>
		<router-link to="/user" class="button">
		  <span class="material-icons">group</span>
		  <span class="text">User</span>
		</router-link>
		<router-link to="/cars" class="button">
		  <span class="material-icons">directions_car</span>
		  <span class="text">Cars</span>
		</router-link>
		<router-link to="/reservation" class="button">
		  <span class="material-icons">handshake</span>
		  <span class="text">Reservation</span>
		</router-link>
		<router-link to="/contact" class="button">
		  <span class="material-icons">email</span>
		  <span class="text">Contact</span>
		</router-link>
	  </div>
  
	  <div class="flex"></div>
  
	  <div class="menu">
		<div class="button" @click="logout">
			<span class="material-icons">logout</span>
		  	<span class="text">Logout</span>
		</div>
	  </div>
	</aside>
  </template>
  
  <script>
  import logoURL from '../assets/logo.png';
  
  export default {
	data() {
	  return {
		is_expanded: localStorage.getItem('is_expanded') === 'true',
		logoURL,
	  };
	},
	methods: {
	  toggleMenu() {
		this.is_expanded = !this.is_expanded; 
		localStorage.setItem('is_expanded', this.is_expanded); 
	  },
	  logout() {
		localStorage.clear(); 
		window.location.reload(); 
	  },
	},
  };
  </script>
  
  <style lang="scss" scoped>
  
  aside {
	display: flex;
	flex-direction: column;
  position: fixed;
	background-color: var(--dark);
	color: var(--light);
  
	width: calc(2rem + 32px);
	overflow: hidden;
	min-height: 49rem;
	padding: 1rem;
  
	transition: 0.2s ease-in-out;
  
	.flex {
	  flex: 1 1 0%;
	}
  
	.logo {
	  margin-bottom: 1rem;
	}
  
	img {
	  margin-left: -0.5rem;
	  width: 3rem;
	}
  
	.menu-toggle-wrap {
	  display: flex;
	  justify-content: flex-end;
	  margin-bottom: 1rem;
  
	  position: relative;
	  top: 0;
	  transition: 0.2s ease-in-out;
  
	  .menu-toggle {
		transition: 0.2s ease-in-out;
		.material-icons {
		  font-size: 2rem;
		  color: var(--light);
		  transition: 0.2s ease-out;
		}
  
		&:hover {
		  .material-icons {
			color: var(--primary);
			transform: translateX(0.5rem);
		  }
		}
	  }
	}
  
	h3,
	.button .text {
	  opacity: 0;
	  transition: opacity 0.3s ease-in-out;
	}
  
	h3 {
	  color: var(--grey);
	  font-size: 0.875rem;
	  margin-bottom: 0.5rem;
	  text-transform: uppercase;
	}
  
	.menu {
	  margin: 0 -1rem;
  
	  .button {
		display: flex;
		align-items: center;
		text-decoration: none;
  
		transition: 0.2s ease-in-out;
		padding: 0.5rem 1rem;
  
		.material-icons {
		  font-size: 2rem;
		  color: var(--light);
		  transition: 0.2s ease-in-out;
		}
		.text {
		  color: var(--light);
		  transition: 0.2s ease-in-out;
		}
  
		&:hover {
		  background-color: var(--dark-alt);
  
		  .material-icons,
		  .text {
			color: var(--primary);
		  }
		}
  
		&.router-link-exact-active {
		  background-color: var(--dark-alt);
		  border-right: 5px solid var(--primary);
  
		  .material-icons,
		  .text {
			color: var(--primary);
			animation: moveUpDown 2s linear infinite;
		  }
		}
	  }
	}
  
	&.is-expanded {
	  width: var(--sidebar-width);
  
	  .menu-toggle-wrap {
		top: -3rem;
  
		.menu-toggle {
		  transform: rotate(-180deg);
		}
	  }
  
	  h3,
	  .button .text {
		opacity: 1;
	  }
  
	  .button {
		.material-icons {
		  margin-right: 1rem;
		}
	  }
	}
  
	@media (max-width: 1024px) {
	  position: absolute;
	  z-index: 99;
	}
  }
  
  @keyframes moveUpDown {
	0%,
	100% {
	  transform: translateY(0);
	}
	50% {
	  transform: translateY(-10px);
	}
  }
  </style>
  