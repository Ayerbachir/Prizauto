<template>

  <div class="table-container" >
    <div class="header">
      <h1><b style="color:#4ade80; font-size: 35px;">R</b>eservation <b style="color:#4ade80; font-size: 35px;">L</b>ist</h1>
    </div>
    <div v-if="showNotification" class="notification">
      {{ notificationMessage }}
    </div>
    <div class="main">
      <div class="lett-nav">
        Add Reservation : 
        <button class="btn" @click="openModal1">Add</button>  
      </div>
    
    <table class="car-table">
      <thead>
        <tr>
          <th>Client Name</th>
          <th>Car Name</th>
          <th>From</th>
          <th>Until</th>
          <th>Total Price</th>
          <th>Paid</th>
          <th>Modify</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="rese in filteredData" :key="rese.id"  >
          <td>{{ rese.user_name }}</td>
          <td>{{ rese.car_name}}/{{ rese.car_model }}/{{ rese.matricul }}</td>
          <td>{{ rese.from }}</td>
          <td>{{ rese.until }}</td>
          <td>{{ rese.price }}</td>
          <td>{{ rese.paid }}</td>
          <td>
            <button class="btn tn" @click="hand(rese)">Edit</button>
            <button class="btn tn" @click="updateState(rese)" >State</button>
            <button class="btn tn" @click="delet(rese)">Delete</button>
          </td> 
        </tr>
      </tbody>
    </table>

    <div v-if="isModalVisible1" class="modal-overlay" @click="closeModal1">
<div class="modal-content" @click.stop>
  <h2>Add Reservation</h2>
  <form @submit.prevent="addCar"> 

    <label for="Uname" class="inp">Client Name:</label>
    <select v-model="newR.user_id">
      <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
    </select><br>

    <label for="Uname" class="inp">Cars Name:</label>
    <select v-model="newR.car_id">
      <option v-for="car in cars" :key="car.id" :value="car.id" v-show="car.state==='Available'">{{ car.name }}/{{ car.model}}/{{ car.matricul }}</option>
    </select><br>

    <label for="from">From:</label>
    <input type="date" id="from" v-model="newR.from" required><br>

    <label for="days">Days:</label>
    <input type="number" id="days" v-model="newR.until" required><br>

    <label for="price">Total Price:</label>
    <input type="number" id="price" :value="calculatedPrice" disabled><br>

    <label for="paid">Paid:</label>
    <input type="number" id="paid" v-model="newR.paid"><br>

    <button type="submit" class="btn">Add</button>
    <button type="button" class="btn cancel-btn" @click="closeModal1">Cancel</button>
  </form>
</div>
</div>

    <div v-if="isModalVisible3" class="modal-overlay" @click="closeModal1">
      <div class="modal-content" @click.stop>
        <h2>Edit User</h2>
        <form @submit.prevent="edit()">

          <label for="name">Client Name:</label>
          <input type="text" id="name"  v-model="newR.user_id"  :disabled=true >

          <label for="model">Cars Name:</label>
          <input type="text" id="model" :disabled=true  v-model="newR.car_id" >

          <label for="price">From:</label>
          <input type="date" id="price" v-model="newR.from" >

          <label for="state">Days:</label>
          <input type="text" id="state" v-model="newR.until" required>

          <label for="nci">Total Price:</label>
          <input type="number" id="nci" v-model="newR.price"  :disabled="true">

          <label for="carname">Paid:</label>
          <input type="text" id="carname" v-model="newR.paid" >

          <button type="submit" class="btn">Edit</button>
          <button type="button" class="btn" @click="closeModal1">Cancel</button>
        </form>
      </div>
    </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios'

export default {
data() {
  return {
    showNotification: false,
    notificationMessage: "",
    isModalVisible1:false,
    isModalVisible2:false,
    isModalVisible3:false,
    users: [], 
    cars: [],
    reseData: [],
    newR: {
      id:'',
      user_id: null, 
      car_id: null, 
      from: "", 
      until: 0,
      price:0,
      paid: 0,
      state:0,
    },
  };
},
computed: {
  calculatedPrice() {
    const selectedCar = this.cars.find(car => car.id === this.newR.car_id);
    return selectedCar ? selectedCar.price * this.newR.until : 0;
  },filteredData() {
      return this.reseData.filter(rese => rese.state ==='0');
    }
  
},mounted(){
  this.fetchCars();
  this.fetchUsers();
  this.fetchCU();
  
},
methods: {
  openModal1(){
    this.fetchCars();
    this.isModalVisible1=true;
    },

  openModal3(rese) {
      this.newR.user_id=rese.user_name;
      this.newR.car_id=rese.car_name;
      this.newR.from=rese.from;
      this.newR.until=rese.until;
      this.newR.price=rese.price;
      this.newR.paid=rese.paid;
      this.newR.state=rese.state;
      this.isModalVisible3 = true;
    },
 
  addCar() {
    this.newR.price = this.calculatedPrice;
    axios.post('http://127.0.0.1:8000/api/caruser', this.newR)
      .then(() => {
        this.notificationMessage = `Reservation  successfully!`;
        this.showNotification = true;
        setTimeout(() => {
          this.showNotification = false;
        }, 1500);
        this.fetchCU();
        this.closeModal1();
      })
      .catch(error => {
        console.error("Error adding reservation:", error);
        this.notificationMessage = "Error adding  reservation. Please try again.";
        this.showNotification = true;
      });
      
  },
  edit() {
},
  closeModal1() {
    this.isModalVisible1 = false;
    this.isModalVisible2 = false;
    this.isModalVisible3 = false;
    this.newR= {
      id:'',
      user_id: null, 
      car_id: null, 
      from: "", 
      until: 0,
      price:0,
      paid: 0,
      state:0,
    }
  },
  fetchCars() {
    axios.get('http://127.0.0.1:8000/api/cars')
      .then(response => {
        this.cars = response.data;
      })
      .catch(error => {
        console.error("Error fetching cars:", error);
      });
  },
  fetchUsers() {
    axios.get('http://127.0.0.1:8000/api/users')
      .then(response => {
        this.users = response.data;
      })
      .catch(error => {
        console.error("Error fetching users:", error);
      });
  },

  fetchCU() {
    axios.get('http://127.0.0.1:8000/api/reservations')
      .then(response => {
        this.reseData = response.data;
      })
      .catch(error => {
        console.error("Error fetching users:", error);
      });
  },
  hand(rese){
      this.openModal3(rese);
      if(!this.isModalVisible3){
        this.edit();
      }
    },
    updateState(rese) {
  axios.patch(`http://127.0.0.1:8000/api/caruser/${rese.id}/state`)
    .then(response => {
      console.log(response.data.message); 
      this.notificationMessage = ` updating successfully!`;
      this.showNotification = true;
        setTimeout(() => {
          this.showNotification = false;
        }, 1500);
      this.fetchCU();
      console.log(this.reseData); 
    })
    .catch(error => {
      console.error("Error updating state:", error);
      this.notificationMessage = "Error deleting the reservation. Please try again.";
      this.showNotification = true;
    });
    this.filteredData;
},
delet(rese) {
  console.log(rese.id);

  if (confirm(`Are you sure you want to delete this reservation?`)) {
    this.notificationMessage = `Reservation for car ${rese.car_name} deleted successfully!`;
        this.showNotification = true;
        setTimeout(() => {
          this.showNotification = false;
        }, 1000);
    this.updateState(rese);
    axios
      .delete(`http://127.0.0.1:8000/api/caruser/${rese.id}`)
      .then(() => {
        this.reseData = this.reseData.filter((c) => c.id !== rese.id);
        
      })
      .catch((error) => {
        console.error("Error deleting reservation:", error);

        this.notificationMessage = "Error deleting the reservation. Please try again.";
        this.showNotification = true;
      });

  }
},




}
};

</script>

<style scoped>

table{
width: 100%;
table-layout: fixed;
border-collapse: collapse;
}
.table-container {
margin: 20px auto;
padding: 1px;
}
.main{
margin-left: 2rem;
}
select{
padding: 3px;
margin-left: 20%;
border-color: #4ade80;
border-radius: 5px;

}
.inp{
padding-top:3rem;
padding-bottom:3rem;

}
.btn {
padding: 6px 12px;
margin-left: 5px;
border-radius: 5px;
background-color: #4ade80;
color: white;
font-size: 14px;
cursor: pointer;
}

.lett-nav {
margin: 6rem 0 1rem 3rem;
display:inline-block;
}

.btn:hover {
background-color: #38a169;
}

.car-table {
width: 100%;
padding: 1rem;
border-collapse: collapse;
table-layout: fixed;
}

.car-table th,
.car-table td {
padding: 8px;
text-align: left;
border: 1px solid #ddd;
}

.car-table th {
background-color: #f2f2f2;
font-weight: bold;
}

.car-table tr:nth-child(even) {
background-color: #f9f9f9;

}

.car-table tr:hover {
background-color: #e2e2e2;
}
.car-table td:last-child {
  text-align: center;
}

.car-table td button {
  margin: 2px;
  padding: 5px 8px;
  font-size: 12px;
}
.modal-overlay {
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
background-color: rgba(0, 0, 0, 0.5);
display: flex;
justify-content: center;
align-items: center;
z-index: 9999; 
}

.modal-content {
background-color: white;
padding: 20px;
border-radius: 8px;
width: 90%; 
max-width: 500px; 
box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
transition: all 0.3s ease-in-out;
}

.modal-content input,
.modal-content select {
width: 100%;
padding: 10px;
margin: 10px 0;
border: 1px solid #ddd;
border-radius: 5px;
font-size: 14px;
}

.modal-content label {
font-size: 16px;
font-weight: bold;
margin-bottom: 5px;
}

.modal-content button {
padding: 10px 20px;
background-color: #4CAF50;
color: white;
border: none;
border-radius: 5px;
cursor: pointer;
font-size: 16px;
margin-right: 10px;
transition: background-color 0.3s ease;
}

.modal-content button:hover {
background-color: #45a049;
}

.modal-content .btn:disabled {
background-color: #bbb;
cursor: not-allowed;
}


.modal-content h2 {
font-size: 24px;
margin-bottom: 20px;
text-align: center;
color: #333;
}

.modal-overlay .modal-content {
animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
from {
  opacity: 0;
}
to {
  opacity: 1;
}
}

.header{
margin-left: 7rem;
}

.modal-content button {
margin-top: 10px;
width: 100%;
}

@media (max-width: 1024px) {
.car-table th,
.car-table td {
  font-size: 14px;
  padding: 10px;
}

.btn {
  padding: 5px 10px;
  font-size: 12px;
}
}

@media (max-width: 768px) {
.car-table th,
.car-table td {
  font-size: 12px;
  padding: 6px;
}

.btn {
  padding: 4px 8px;
  font-size: 10px;
}

.table-container {
  padding: 10px;
}
}

@media (max-width: 775px) {
.car-table th,
.car-table td {
  font-size: 10px;
  padding: 4px;
}
.lett-nav{
  margin: 0;
  display:inline-block
}
.btn {
  padding: 3px 6px;
  font-size: 8px;
}

.car-table th {
  font-size: 10px;
}

.table-container {
  padding: 5px;
  margin-left: 20%;
}
}
.notification {
  position: fixed;
  top: 20px;
  right: 20px;
  padding: 10px 20px;
  background-color: #4ade80; /* Success green */
  color: white;
  border-radius: 5px;
  font-size: 16px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  z-index: 1000;
  animation: fadeInOut 1.5s ease-in-out;
}

@keyframes fadeInOut {
  0% {
    opacity: 0;
    transform: translateY(-20px);
  }
  10% {
    opacity: 1;
    transform: translateY(0);
  }
  90% {
    opacity: 1;
    transform: translateY(0);
  }
  100% {
    opacity: 0;
    transform: translateY(-20px);
  }
}

</style>