@extends('layouts.master')
@section('content')
    <style>
        .dark-mode .page-item .page-link {
            color: #fff !important;
        }
    </style>

    <section class="content" id="app">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Alumni List</h5>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped" v-if="isDatatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Reg Code</th>
                                <th>Department</th>
                                <th>Batch</th>
                                <th>Mobile</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- ✅ Load Vue, Axios, jQuery, DataTables -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script> --}}

    <script>
        new Vue({
            el: '#app',
            data: {
                summery: [],
                table: null,
                isDatatable: false,
            },
            methods: {
                loadTable() {
                    const vm = this;
                    axios.get('/get-alumni')
                        .then(response => {
                            vm.summery = response.data;
                            vm.isDatatable = true;

                            vm.$nextTick(() => {
                                if (vm.table && $.fn.DataTable.isDataTable('#example1')) {
                                    vm.table.destroy();
                                    $('#example1 tbody').empty();
                                }

                                let tbody = '';
                                vm.summery.forEach((item, index) => {
                                    let phones = [];
                                    try {
                                        phones = JSON.parse(item.phone);
                                        if (!Array.isArray(phones)) phones = [phones];
                                    } catch (e) {
                                        phones = [item.phone];
                                    }

                                    let phoneStr = phones.join(', ');
                                    tbody += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.name}</td>
                                    <td>${item.reg_code}</td>
                                    <td>${item.department}</td>
                                    <td>${item.batch}</td>
                                    <td>${phoneStr}</td>
                                </tr>`;
                                });
                                $('#example1 tbody').html(tbody);

                                vm.table = $('#example1').DataTable({
                                    responsive: true,
                                    lengthChange: true,
                                    autoWidth: false,
                                    // buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
                                });

                                vm.table.buttons().container()
                                    .appendTo('#example1_wrapper .col-md-6:eq(0)');
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                        });
                }
            },
            mounted() {
                this.loadTable();
            }
        });
    </script>
@endsection
