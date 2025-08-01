<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>

<div id="app" class="container">
    <!-- Modal -->
    <div
        class="modal fade"
        id="payment_popup"
        data-backdrop="static"
        data-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Payment</h5>
                </div>
                <div class="modal-body">
                    <center>
                        <div
                            id="qrcode"
                        ></div>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div
            class="col-md-3 mt-4"
            v-for="(item, index) in product_list"
        >
            <div class="card" style="width: 100%">
                <img
                    :src="item.image"
                    class="card-img-top"
                    style="height: 200px; width: 200px; object-fit: contain"
                    alt="..."
                >
                <div class="card-body">
                    <h5 class="card-title">[[ item.title ]]</h5>
                    <p class="card-text">៛ [[ (item.price * 4100).toLocaleString() ]]</p>
                    <button
                        class="btn btn-primary"
                        @click="onBuy(item.price)"
                    >Buy
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
@include('shop.script')
<script>
    const {createApp} = Vue
    createApp({
        delimiters: ['[[', ']]'],
        created() {
            this.fetchProduct()
        },
        data() {
            return {
                message: 'Hello Vue!',
                product_list: [],
                qr_string: ''
            }
        },
        methods: {
            fetchProduct() {
                let vm = this
                axios.get('https://fakestoreapi.com/products')
                    .then(function (response) {
                        // handle success
                        vm.product_list = response.data
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error)
                    })

            },
            onBuy(price) {
                let url = 'http://127.0.0.1:8001/generate-qrcode'
                let payload = {
                    amount: price
                }
                let vm = this
                axios.post(url, payload)
                    .then(function (response) {
                        // handle success
                        vm.qr_string = response.data.data.qr
                        let md5 = response.data.data.md5

                        var qrString = response.data.data.qr
                        var qr = new QRCode(document.getElementById("qrcode"), {
                            text: qrString,
                            width: 256,
                            height: 256,
                        });

                        $('#payment_popup').modal('show')
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error)
                    })


            }
        }
    }).mount('#app')
</script>
</html>
