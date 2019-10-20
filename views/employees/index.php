<?php
$this->load->view('header');
?>
<style>
    .dataTables_filter { display: none; }
    .dataTables_wrapper .dt-buttons {
        float:right;  
        text-align:center;
        font-size:12px;
    }
    .dataTables_paginate{
        font-size:10px;
        margin-bottom:5px;
    }
    .dataTables_length{
        font-size:12px;
        margin-bottom:5px;    
    }
    .dataTables_info{
        font-size:12px;
    }
</style>
<section class="showcase">
    <div class="container">
        <div class="pb-2 mt-4 mb-2 border-bottom">
        <h2>Orders with Filter and Export options</h2>
      </div>
      <div class="row">
          <div class="col-lg-12"><span id="success-msg"></div>
      </div>

        <div class="row">
            
            <div class="col-lg-12">

                <div class="row">
                    <div class="col-lg-4 col-sm-4">
                        <div class="form-group"> 
							<input type="text" class="form-control column_filter" id="datepickers" placeholder="Start Date">
                        </div>

                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="form-group">                        
                            <input type="text" class="form-control column_filter" id="datepickere" placeholder="End Date">
							
                        </div>

                    </div>
					<div class="col-lg-4 col-sm-4">
                        <div class="form-group">                        
                            <input type="text" class="form-control column_filter" id="keyword" placeholder="Any Keyword...">
							
                        </div>

                    </div>

                    
                </div>                
            </div>
        </div>
        <div class="table-responsive">
            <table id="render-datatable" class="table table-bordered table-hover small"> 
                <thead>
				
                    <tr>
                        <th scope="col">Order Id</th>
						<th scope="col">Status</th>
						<th scope="col">Delivery Status</th>
						<th scope="col">Payment Status</th>
						<th scope="col" display="none">Status</th>
						<th scope="col" display="none">Delivery Status</th>
						<th scope="col" display="none">Payment Status</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Customer MobileNo</th>
                        <th scope="col">Customer Address</th>
                        <th scope="col">Customer Area</th>
                        <th scope="col">Chef Name</th>
                        <th scope="col">Chef MobileNo</th>
						<th scope="col">Chef Address</th>
						<th scope="col">Chef Area</th>
						<th scope="col">Total</th>
						<th scope="col">MenuItems</th>
						<th scope="col">Quantity</th>
						<th scope="col">Rejected Reason</th>
						<th scope="col">Special Instructions</th>
						<th scope="col">OrderAt</th>
						<th scope="col">UpdateAt</th>
						<th scope="col">DeliveryName</th>
						
						
						
												
                    </tr>
                </thead> 
                <tbody> 
                </tbody> 
                <tfoot> 
                    <tr>
                        <th scope="col">Order Id</th>
						<th scope="col">Status</th>
						<th scope="col">Delivery Status</th>
						<th scope="col">Payment Status</th>
						<th scope="col" display="none">Status</th>
						<th scope="col" display="none">Delivery Status</th>
						<th scope="col" display="none">Payment Status</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Customer MobileNo</th>
                        <th scope="col">Customer Address</th>
                        <th scope="col">Customer Area</th>
                        <th scope="col">Chef Name</th>
                        <th scope="col">Chef MobileNo</th>
						<th scope="col">Chef Address</th>
						<th scope="col">Chef Area</th>
						<th scope="col">Total</th>
						<th scope="col">MenuItems</th>
						<th scope="col">Quantity</th>
						<th scope="col">Rejected Reason</th>
						<th scope="col">Special Instructions</th>
						<th scope="col">OrderAt</th>
						<th scope="col">UpdateAt</th>
						<th scope="col">DeliveryName</th>

						
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</section>

<?php
$this->load->view('employees/popup/display');
$this->load->view('employees/popup/edit');
$this->load->view('employees/popup/add');
$this->load->view('employees/popup/delete');
//$this->load->view('templates/footer');
?>
<script src="<?php echo base_url('assets/custom.js')?>"></script>
<script type="text/javascript">

	Array.prototype.contains = function(v) {
		for(var i = 0; i < this.length; i++) {
			if(this[i] === v) return true;
		}
		return false;
	};
	var statusOptions =null;
	var deliveryOptions =null;
	var paymentOptions =null;
	var a=1;
	var b=1;
	var c=1;
	
    jQuery(document).ready(function () {
		
		var orderArray = {
			orderStatus: []
		};
		
		statusOptions = new Array();
		statusOptions.push('complete');
		statusOptions.push('rejected');
		statusOptions.push('preparing');
		statusOptions.push('accepted');
		statusOptions.push('new');
		
		deliveryOptions = new Array();
		deliveryOptions.push('complete');
		deliveryOptions.push('pending');
		deliveryOptions.push('allotted');
		
		paymentOptions = new Array();
		paymentOptions.push('paid');
		paymentOptions.push('unpaid');
		
		$('#datepickers').datepicker({
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: "yy/m/d"
		}).datepicker("setDate", new Date());
		
		$('#datepickere').datepicker({
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: "yy/m/d"
		}).datepicker("setDate", new Date());
		
		
		var baseurl="http://localhost:8081/delibee_order/";
         var tableData = jQuery('#render-datatable').DataTable({
			"paging": false,
			'ajax': {
				"type"   : "POST",
				"url"    : baseurl+"curd/getAllEmployees",
				"data"   : function( data ) {
					data.keyword = $('#keyword').val();
                    data.datepickers = $('#datepickers').val();
                    data.datepickere = $('#datepickere').val();
				},
				
				"dataSrc": function ( json ) {
                //Make your callback here.
						/*statusOptions = new Array();
						deliveryOptions = new Array();
						paymentOptions = new Array();
						
					    $.each(json.data, function (i, item){
							if(!statusOptions.contains(item.Status)){
								statusOptions.push(item.Status);
							}
							if(!deliveryOptions.contains(item.DeliveryStatus)){
								deliveryOptions.push(item.DeliveryStatus);
							}
							if(!paymentOptions.contains(item.PaymentStatus)){
								paymentOptions.push(item.PaymentStatus);
							}
						});*/
					return json.data;
				}   
				//"dataSrc": "data"
			},
			
			dom: 'lBfrtip',
            buttons: [
			
				{
					text: 'Upload',
					action: function () {
						debugger;
						var table = $('#render-datatable').DataTable();
						var fieldNames =  [], json = []
						
						//table.rows().data().toArray().forEach(function(row) {
						  //var item = {}
						  //row.forEach(function(content, index) {
							// item[fieldNames[index]] = content
						  //})
						 // json.push(item)
						//})  
						var table1=document.getElementById("render-datatable");
						var totalRows = table1.rows.length;
						var orderIdPost=0;
						for (var i = 1, row; row = table1.rows[i]; i++) {
						//iterate through rows
						//rows would be accessed using the "row" variable assigned in the for loop
							if(i<totalRows-1){
								for (var j = 0, col; col = row.cells[j]; j++) {
									orderIdPost=col.innerText;
									break;
								}
								
							var ddlStatusValue = document.getElementById("ddlStatus"+i);
							var ddlDeliveryStatusValue = document.getElementById("ddlDeliveryStatus"+i);
							var ddlPaymentStatusValue = document.getElementById("ddlPaymentStatus"+i);
							
							//var strUser = ddlStatusValue.options[e.selectedIndex].text;
							
							orderArray.orderStatus.push({ 
								"orderId" : orderIdPost,
								"staus"  : ddlStatusValue.options[ddlStatusValue.selectedIndex].text,
								"delievery" : ddlDeliveryStatusValue.options[ddlDeliveryStatusValue.selectedIndex].text,
								"payment" : ddlPaymentStatusValue.options[ddlPaymentStatusValue.selectedIndex].text								
							});
							}
							
							
							
						}
						
						
						$.ajax({
							 url: baseurl+"curd/orderPostData",
							 type: 'POST',
							 data: {orderArray: orderArray},
							 error: function() {
								alert('Something is wrong');
							 },
							 success: function(data) {
								a=1;
								b=1;
								c=1;
								tableData.ajax.reload();
								alert(data);  
							 }
						});
						
						
						
						}
				},
				{
					text: 'Reload table',
					action: function () {
							a=1;
							b=1;
							c=1;
						tableData.ajax.reload();
					}
				},
			
				{
                    extend: 'excel',
                    text: '<i class="far fa-file-excel" aria-hidden="true"></i> Excel Export',
                    filename: 'orders',
                    title: '',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'all'
                        },
                        columns: [0,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19]
						//columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="far fa-csv"></i> Export CSV',
                    filename: 'orders',
                    title: '',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'all'
                        },
                        columns: [0,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19]
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="far fa-file-pdf" aria-hidden="true"></i> PDF',
                    filename: 'members',
                    title: '',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'all'
                        },
                        columns: [0,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19]
                    }
                },
            ],
			'columns': [
				{"data" : "OrderId"},
				{"data" : "Status"},
				{"data" : "DeliveryStatus"},
				{"data" : "PaymentStatus"},
				{"data" : "Status"},
				{"data" : "DeliveryStatus"},
				{"data" : "PaymentStatus"},
				{"data" : "CustomerName"},
				{"data" : "CustomerMobileNo"},
				{"data" : "CustomerAddress"},
				{"data" : "CustomerArea"},
				{"data" : "ChefName"},
				{"data" : "ChefMobileNo"},
				{"data" : "ChefAddress"},
				{"data" : "ChefArea"},
				{"data" : "Total"},
				{"data" : "MenuItems"},
				{"data" : "Quantity"},
				{"data" : "RejectedReason"},
				{"data" : "SpecialInstructions"},
				{"data" : "OrderAt"},
				{"data" : "UpdateAt"},
				{"data" : "DeliveryName"}
				
				
			],
			columnDefs:[{targets:[1], render : 
							function(data){return createStatus(data);}}  ,
						{targets:[2], render : 
							function(data){return createDeliveryStatus(data);}}	,
						{targets:[3], render : 
							function(data){return createPaymentStatus(data);}},

						{targets: [4],
							"visible": false
						},
						{targets: [5],
							"visible": false
						},
						{targets: [6],
							"visible": false
						}						
            ]
        });

        
        
    });
	
	function createStatus(selItem){
			//alert(statusOptions.length);
			var sel = "<select id='ddlStatus"+a+"'>" ;
			for(var i = 0; i < statusOptions.length; ++i){
				
			if(statusOptions[i] == selItem){
				sel += "<option value = '"+statusOptions[i]+"' selected='selected'>" + statusOptions[i] + "</option>";
			}
			else{
				sel += "<option  value = '"+statusOptions[i]+"' >" + statusOptions[i] + "</option>";
			}
		}
		a=a+1;
			sel += "</select>";
			return sel;
	}
	
	
	function createDeliveryStatus(selItem){
			
			var sel = "<select id='ddlDeliveryStatus"+b+"'>" ;
			for(var i = 0; i < deliveryOptions.length; ++i){
			if(deliveryOptions[i] == selItem){
				sel += "<option selected value = '"+deliveryOptions[i]+"' >" + deliveryOptions[i] + "</option>";
			}
			else{
				sel += "<option  value = '"+deliveryOptions[i]+"' >" + deliveryOptions[i] + "</option>";
			}
			}
			b=b+1;
			sel += "</select>";
			return sel;
	}
	
	
	function createPaymentStatus(selItem){
    
			var sel = "<select id='ddlPaymentStatus"+c+"'>" ;
			for(var i = 0; i < paymentOptions.length; ++i){
			if(paymentOptions[i] == selItem){
				sel += "<option selected value = '"+paymentOptions[i]+"' >" + paymentOptions[i] + "</option>";
			}
			else{
				sel += "<option  value = '"+paymentOptions[i]+"' >" + paymentOptions[i] + "</option>";
			}
		}
		c=c+1;
			sel += "</select>";
			return sel;
	}

</script>