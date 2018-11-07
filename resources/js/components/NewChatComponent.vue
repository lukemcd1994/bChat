<template>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">New Chat</div>
						<div class="card-body">
						<form>
							<div class='col-md-12'>
								<div class="form-group">
							    <label for="With"><b>With:</b></label>
							    <input type="With" class="form-control" id="w" placeholder="Enter username">
							  </div>
							</div>
							<div class='col-md-12'>
								<div class="form-group">
							    <label for="EndAt"><b>End At:</b></label>
							    <input type="EndAt" class="form-control" id="ea" placeholder="mm/dd/yyyy">
							  </div>
							</div>
							<br>
							<div class="row justify-content-center">
								<div class='col-xs-12'>
									<button class="btn btn-primary" @click="">Create Chat</button>
								</div>
							</div>
						</form>
						</div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
