<template>
    <div>
        <h1>{{ msg }}</h1>

        <router-link to="/shipping-list" class="link-success">Go to list of shipping</router-link>

        <div class="container">
            <div class="mb-3">
                <label for="carrier" class="form-label">Carrier</label>
                <select class="form-select" v-model="carrier" id="carrier">
                    <option value="trans_company">TransCompany</option>
                    <option value="pack_group">PackGroup</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="weight" class="form-label">Weight</label>
                <input type="number" class="form-control" v-model="weight"
                       id="weight" placeholder="0.00" step="0.01"
                >
            </div>
            <button class="btn btn-primary" @click="calculatePrice">Calculate</button>

            <div v-if="price !== null" class="alert alert-primary" role="alert">
                <div>Price: {{ price }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        msg: String
    },
    data() {
        return {
            carrier: 'trans_company',
            weight: '0.00',
            price: null,
            error: null
        };
    },
    methods: {
        async calculatePrice() {
            this.error = null;
            try {
                const response = await fetch(process.env.VUE_APP_API_URL + '/api/shipping', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ carrier: this.carrier, weight: this.weight })
                });

                if (!response.ok) {
                    throw new Error('Server Error');
                }

                const data = await response.json();
                this.price = data.cost + ' EUR';
            } catch (error) {
                this.price = '--';
                this.error = error.message;
            }
        }
    }
}
</script>

<style scoped>
    .container {
      text-align: left;
    }

    .alert {
        margin-top: 20px;
    }
</style>
