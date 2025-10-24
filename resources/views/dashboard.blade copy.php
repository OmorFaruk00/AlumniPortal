@extends('layouts.master')
@section('content')
<style>
    .dark-mode .page-item .page-link {
    color: #fff !important;
}
</style>
    <section class="content" id="app">
        <div class="container-fluid">

            <h3>City Bank Transection Summery</h3>

            <div class="row mb-3">
                <div class="col-md-3 mb-3">
                    <input type="date" class="form-control" v-model="start">
                </div>
                <div class="col-md-3 mb-3">
                    <input type="date" class="form-control" v-model="end">
                </div>
                <div class="col-md-3 mb-3">
                    <button class="btn btn-success" @click="loadTable">Search</button>
                </div>
            </div>

            <table id="example1" class="table table-bordered table-striped" v-if="isDatatable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Student Name</th>
                        <th>Phone Number</th>
                        <th>Transection Id</th>
                        <th>Transection Date</th>
                        <th>Purpose Pay</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>
    </section>
    <script>
        new Vue({
            el: '#app',
            data: {
                start: '2025-09-01',
                end: '2025-09-20',
                employe_id:491,
                summery: [],
                table: null,
                isDatatable:false,
            },
            methods: {
                loadTable() {
                    const vm = this;

                    axios.post('/collection-summery',{
                        start:this.start,
                        end:this.end,
                        employee_id:this.employe_id
                    })
                        .then(response => {
                            vm.summery = response.data.data;
                            vm.isDatatable = true;

                            vm.$nextTick(() => {
                                if (vm.table && $.fn.DataTable.isDataTable('#example1')) {
                                    vm.table.destroy();
                                    $('#example1 tbody').empty();
                                }
                                let tbody = '';
                                vm.summery.forEach((item, index) => {
                                    tbody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${item.name}</td>
                                        <td>${item.phone}</td>
                                        <td>${item.receipt_no}</td>
                                        <td>${item.date_bank}</td>
                                        <td>${item.purpose_pay}</td>
                                        <td>${item.amount}</td>
                                    </tr>`;
                                });
                                $('#example1 tbody').html(tbody);
                                vm.table = $('#example1').DataTable({
                                    responsive: true,
                                    lengthChange: true,
                                    autoWidth: false,
                                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
                                });

                                vm.table.buttons().container().appendTo(
                                    '#example1_wrapper .col-md-6:eq(0)');
                            });

                        })
                        .catch(error => {
                            console.log('Error fetching data:', error);
                        });
                }
            },

        });
    </script>
@endsection
