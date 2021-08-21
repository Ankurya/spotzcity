<div class="row">
  <div class="form-group clearfix">
    <div class="col-md-6 col-xs-12">
      <label for="resource_name">Name*</label>
      <input class="form-control" name="resource_name" value="{{$resource->name}}" required>
    </div>
    <div class="col-md-6 col-xs-12">
      <label for="category">Category*</label>
      <select class="form-control" name="category" value="{{$resource->category}}" required>
        @foreach($categories as $category)
          <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-6 col-xs-12">
      <label for="type">Type (if applicable)</label>
      <input class="form-control" name="type" value="{{$resource->type}}">
    </div>
  </div>
  <div class="form-group clearfix">
    <div class="col-md-6 col-xs-12">
      <label for="city">City*</label>
      <input class="form-control" name="city" value="{{$resource->city}}" required>
    </div>
    <div class="col-md-6 col-xs-12">
      <label for="state">State*</label>
      <select class="form-control" name="state" value="{{$resource->state}}" required>
        <option value="Alabama">Alabama</option>
        <option value="Alaska">Alaska</option>
        <option value="American Samoa">American Samoa</option>
        <option value="Arizona">Arizona</option>
        <option value="Arkansas">Arkansas</option>
        <option value="California">California</option>
        <option value="Colorado">Colorado</option>
        <option value="Connecticut">Connecticut</option>
        <option value="Delaware">Delaware</option>
        <option value="District Of Columbia">District Of Columbia</option>
        <option value="Federated States Of Micronesia">Federated States Of Micronesia</option>
        <option value="Florida">Florida</option>
        <option value="Georgia">Georgia</option>
        <option value="Guam">Guam</option>
        <option value="Hawaii">Hawaii</option>
        <option value="Idaho">Idaho</option>
        <option value="Illinois">Illinois</option>
        <option value="Indiana">Indiana</option>
        <option value="Iowa">Iowa</option>
        <option value="Kansas">Kansas</option>
        <option value="Kentucky">Kentucky</option>
        <option value="Louisiana">Louisiana</option>
        <option value="Maine">Maine</option>
        <option value="Marshall Islands">Marshall Islands</option>
        <option value="Maryland">Maryland</option>
        <option value="Massachusetts">Massachusetts</option>
        <option value="Michigan">Michigan</option>
        <option value="Minnesota">Minnesota</option>
        <option value="Mississippi">Mississippi</option>
        <option value="Missouri">Missouri</option>
        <option value="Montana">Montana</option>
        <option value="Nebraska">Nebraska</option>
        <option value="Nevada">Nevada</option>
        <option value="New Hampshire">New Hampshire</option>
        <option value="New Jersey">New Jersey</option>
        <option value="New Mexico">New Mexico</option>
        <option value="New York">New York</option>
        <option value="North Carolina">North Carolina</option>
        <option value="North Dakota">North Dakota</option>
        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
        <option value="Ohio">Ohio</option>
        <option value="Oklahoma">Oklahoma</option>
        <option value="Oregon">Oregon</option>
        <option value="Palau">Palau</option>
        <option value="Pennsylvania">Pennsylvania</option>
        <option value="Puerto Rico">Puerto Rico</option>
        <option value="Rhode Island">Rhode Island</option>
        <option value="South Carolina">South Carolina</option>
        <option value="South Dakota">South Dakota</option>
        <option value="Tennessee">Tennessee</option>
        <option value="Texas">Texas</option>
        <option value="Utah">Utah</option>
        <option value="Vermont">Vermont</option>
        <option value="Virgin Islands">Virgin Islands</option>
        <option value="Virginia">Virginia</option>
        <option value="Washington">Washington</option>
        <option value="West Virginia">West Virginia</option>
        <option value="Wisconsin">Wisconsin</option>
        <option value="Wyoming">Wyoming</option>
      </select>
      <script>
        // Select the state
        document.querySelector('option[value={{$resource->state}}]').selected = true
      </script>
    </div>
    <div class="col-md-6 col-xs-12">
      <label for="phone">Phone</label>
      <input class="form-control" name="phone" value="{{$resource->phone}}">
    </div>
    <div class="col-md-6 col-xs-12">
      <label for="website">Website</label>
      <input class="form-control" name="website" value="{{$resource->website}}">
    </div>
  </div>
</div>
<hr>
<div class="row">
  <div class="col-xs-12">
    <div role="toolbar" class="btn-toolbar">
      <button type="submit" class="btn btn-primary">Submit</button>
      <a href="{{ url()->previous() }}" style="margin-left: 15px;">Cancel</a>
      <span style="margin-left: 15px;">* Admins will have to approve the submission</span>
    </div>
  </div>
</div>
