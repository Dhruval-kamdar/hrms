@extends('layouts.app')
@section('content')
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			{{ Form::open( array('method' => 'post', 'class' => 'form-horizontal','files' => true, 'id' => 'addLeaveCategoryType' )) }}

			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Add New Leave Type</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>

					<div class="ibox-content">
						<div class="form-group">
							<label class="col-lg-2 control-label">Name:</label>
							<div class="col-lg-10">
								<input type="text" class="form-control" name="leave_cat_name" placeholder="Enter Name">
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">Type:</label>
							<div class="col-lg-10">
                                <label class="radio-inline">
                                    <input type="radio" name="type" class="fulltime" value="Paid" checked>Paid
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="type" class="fulltime" value="Unpaid">Unpaid
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="type" class="fulltime" value="OnDuty">OnDuty
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="type" class="fulltime" value="Restricted Holiday">Restricted Holiday
                                </label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">Leave Unit:</label>
							<div class="col-lg-10">
                                <label class="radio-inline">
                                    <input type="radio" name="leave_unit" class="fulltime" value="Days" checked>Days
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="leave_unit" class="fulltime" value="Hours">Hours
                                </label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">Description:</label>
							<div class="col-lg-10">
                                <textarea cols="15" rows="5" class="form-control" name="description" placeholder="Enter Description"></textarea>
                            </div>
						</div>

						<br><h4>Applicalbe For:</h4>
						<div class="form-group">
							<label class="col-lg-2 control-label">For:</label>
							<div class="col-lg-10">
                                <label class="radio-inline">
                                    <input type="radio" name="applicable_for" class="fulltime" value="Role/Location" checked>Role/Location
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="applicable_for" class="fulltime" value="Employee">Employee
                                </label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">Role:</label>
							<div class="col-lg-8">
                                <select class="form-control" name="role" id="role">
                                	<option value="">Select Option</option>
                                	@if(!empty($leave_category_role))
	                                	@foreach($leave_category_role as $key => $val)
	                                		<option value="{{$key}}">{{$val}}</option>
	                                	@endforeach
	                                @endif
                                </select>
							</div>
							<div class="col-lg-2">
							<a href="#addRoleModel" class="btn btn-sm btn-primary" data-toggle="modal" title="Add" data-original-title="Add" ><i class="fa fa-plus"></i></a>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">Work Location:</label>
							<div class="col-lg-8">
                                <select class="form-control" name="work_location" id="work_location">
                                	<option>Select Option</option>
                                	@if(!empty($leave_work_location))
	                                	@foreach($leave_work_location as $key => $val)
	                                		<option value="{{$key}}">{{$val}}</option>
	                                	@endforeach
	                                @endif
                                </select>
							</div>
							<div class="col-lg-2">
							<button class="btn btn-sm btn-primary" ><i class="fa fa-plus"></i></button>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">Gender:</label>
							<div class="col-lg-10">
                                <label class="radio-inline">
                                    <input type="radio" name="gender" class="fulltime" value="Male" checked>Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" class="fulltime" value="Female">Female
                                </label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">Marital Status:</label>
							<div class="col-lg-10">
                                <label class="radio-inline">
                                    <input type="radio" name="marital_status" class="fulltime" value="Single" checked>Single
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="marital_status" class="fulltime" value="Married">Married
                                </label>
							</div>
						</div>

						<br><h4>Leave Entitlement:</h4>
						<div class="form-group">
							<label class="col-lg-2 control-label">Period:</label>
							<div class="col-lg-10">
                                <select class="form-control" name="period" id="period">
                                	<option>Select Option</option>
                                	<option value="Annual">Annual</option>
                                	<option value="Monthly">Monthly</option>
                                </select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">For :</label>
							<div class="col-lg-10">
                                <label class="radio-inline">
                                    <input type="radio" name="for_employee_type" class="fulltime" value="All Employees" checked>All Employees
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="for_employee_type" class="fulltime" value="Experience Based">Experience Based
                                </label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">Leave Count :</label>
							<div class="col-lg-10">
                                <input type="number" name="leave_count" class="form-control"> day(s)/year
							</div>
						</div>

						<div class="form-group">
                            <div class="col-lg-offset-5 col-lg-6">
                                <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>

	<div id="addRoleModel" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Role</h4>
            </div>
            
			
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
					<form id="addRole" class="form-horizontal" method="post" action="">
			            <div class="form-group">
						{{ csrf_field() }}
                            <label class="col-sm-2 control-label">Role Name</label>
                            <div class="col-sm-9">
							<input type="text" class="form-control" name="action" id="action" value="addRoleName">
							<input type="text" class="form-control" name="role_name" id="role_name" placeholder="Role Name">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                
                    <button class="btn btn-sm btn-default pull-right m-l " data-dismiss="modal">Close</button>
                    <a class="btn btn-sm btn-primary pull-right addRole m-l" >Add</a>
                
            </div>
            </form>
        </div>
    </div>
</div>
@endsection