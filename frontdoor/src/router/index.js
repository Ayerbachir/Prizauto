import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import User from '../views/user.vue'
import Cars from '../views/Cars.vue'
import Contact from '../views/Contact.vue'
import Reservation from '../views/reservation.vue'
const router = createRouter({
	history: createWebHistory(),
	routes: [
		{
			path: '/',
			component: Dashboard
		},
		{
			path:'/user',
			component:User
		},
		{
			path:'/cars',
			component:Cars
		},
		{
			path: '/contact',
			component:Contact
		},
		{
			path: '/reservation',
			component:Reservation
		},
	],
})

export default router