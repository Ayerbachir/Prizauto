
<template>
	
	<div class="app">
	  <div v-show="!test">
		<login @verif2="verif2" />
	  </div>
  
	  <div v-show="test">
		<Sidebar />
	  </div>
	  <div class="vieu">
		<router-view style="margin: 4rem;" v-show="test" />
	  </div>
	</div>
  </template>
  
  <script>
  import Sidebar from './components/Sidebar.vue';
  import login from './components/login.vue';
  
  export default {
	components: {
	  Sidebar,
	  login,
	},
	data() {
	  return {
		test: false, // Default: show login page
	  };
	},
	methods: {
	  verif2(isValid) {
		if (isValid) {
		  this.test = true; // Switch to Sidebar and Router View if login is successful
		} else {
		  alert('Invalid username or password!');
		}
	  },
	},
  };
  </script>
  
  <style lang="scss">
  :root {
	--primary: #4ade80;
	--primary-alt: #22c55e;
	--grey: #64748b;
	--dark: #1e293b;
	--dark-alt: #334155;
	--light: #f1f5f9;
	--sidebar-width: 300px;
  }
  
  * {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	font-family: 'Fira sans', sans-serif;
  }
  
  body {
	background: var(--light);
}
  
  button {
	cursor: pointer;
	appearance: none;
	border: none;
	outline: none;
	background: none;
  }
  .app {
	display: flex;
  
	main {
	  flex: 1 1 0;
	  padding: 2rem;
	}
  }
  </style>
  