<template>
    <div>
        <h1>{{ msg }}</h1>

        <router-link to="/" class="link-success">Go to shipping calculator</router-link>

        <div class="container">
            <div class="mb-3">
                <div v-if="isLoading" class="status-loading" role="status">
                    <span>Loading...</span>
                </div>
                <table v-if="!isLoading && list && list.length > 0" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Carrier Slug</th>
                            <th scope="col">Weight</th>
                            <th scope="col">Shipping Price</th>
                            <th scope="col">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in list" :key="item.id">
                            <th scope="row">{{ item.id }}</th>
                            <td>{{ item.carrier }}</td>
                            <td>{{ item.weight }}</td>
                            <td>{{ item.price }}</td>
                            <td>{{ formatDate(item.createdAt) }}</td>
                        </tr>
                    </tbody>
                </table>

                <div v-else-if="!isLoading && error" class="alert alert-danger" role="alert">
                    {{ error }}
                </div>

                <div v-else-if="!isLoading && !list" class="alert alert-info" role="alert">
                    No shipping data available.
                </div>
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
            list: null,
            error: null,
            isLoading: true
        };
    },
    methods: {
        async fetchShipping() {
            this.error = null;
            this.isLoading = true;
            try {
                const response = await fetch(process.env.VUE_APP_API_URL + '/api/shipping', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                });

                if (!response.ok) {
                    throw new Error('Server Error');
                }

                this.list = await response.json();
            } catch (error) {
                this.error = error.message;
            } finally {
                this.isLoading = false;
            }
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');
            return `${day}.${month}.${year} ${hours}:${minutes}:${seconds}`;
        }
    },
    mounted() {
        this.fetchShipping();
    }
}
</script>

<style scoped>
    .container {
      text-align: left;
    }

    table, .alert, .status-loading {
        margin-top: 40px;
    }
</style>
