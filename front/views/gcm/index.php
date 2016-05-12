<script type="text/javascript">

  function sendPushNotification(id){
      var data = $('form#'+id).serializeArray();
      var o = {};
      $.each(data, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
     });
      
      $('form#'+id).unbind('submit');
      $.ajax({
          url: "http://gcm.janet.vn/gcm/send",
          type: 'POST',
          data: JSON.stringify(o),
          beforeSend: function() {
               
          },
          success: function(data, textStatus, xhr) {
            if (data.type == 1) {
              alert(data.message);
            }
            else {
              alert('send OK');
            }
             
          },
          error: function(xhr, textStatus, errorThrown) {
               
          }
      });
      return false;
  }
</script>
<style type="text/css">
  .container{
      width: 950px;
      margin: 0 auto;
      padding: 0;
  }
  h1{
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      font-size: 24px;
      color: #777;
  }
  div.clear{
      clear: both;
  }
  ul {
    list-style:none;
  }
  ul >li {
    float:left;
    padding:10px;
  }
  ul.devices{
      margin: 0;
      padding: 0;
  }
  ul.devices li{
      float: left;
      list-style: none;
      border: 1px solid #dedede;
      padding: 10px;
      margin: 0 15px 25px 0;
      border-radius: 3px;
      -webkit-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
      -moz-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
      box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      color: #555;
  }
  ul.devices li label, ul.devices li span{
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      font-size: 12px;
      font-style: normal;
      font-variant: normal;
      font-weight: bold;
      color: #393939;
      display: block;
      float: left;
  }
  ul.devices li label{
      height: 25px;
      width: 50px;                
  }
  ul.devices li textarea{
      float: left;
      resize: none;
  }
  ul.devices li .send_btn{
      background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
      background: -webkit-linear-gradient(0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
      background: -moz-linear-gradient(center top, #0096FF, #005DFF);
      background: linear-gradient(#0096FF, #005DFF);
      text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);
      border-radius: 3px;
      color: #fff;
  }
</style>
<div class="container">
  <h1>No of Devices Registered: {{$data->total}}</h1>
  <ul>
  {foreach from=$data->gcms key=k item=v} 
  <li style="border:1px solid #cccccc; padding:20px;margin-left:10px;">
      <form id="{{$k}}" name="" method="post" onsubmit="return sendPushNotification('{{$k}}')">
          <div style="display:none">
          <label>gcm_regid: </label> <span>{{$v->gcm_regid}}</span>
          <div class="clear"></div>
          </div>
          <label>hardware_id: </label> <span>{{$v->hardware_id}}</span>
          <div class="clear"></div>
          <label>hardware_info: </label> <span>{{$v->hardware_info}}</span>
          <div class="clear"></div>
          <label>email: </label> <span>{{$v->email}}</span>
          <div class="clear"></div>
          <div class="send_container">
              <table>
                <tr>
                  <td>
                Title
                </td>
                <td>
                  <input type="text" name="title" /></div>
                </td>
                </tr>
              <tr>
                <td>
                Content
                </td>
                <td>
              <textarea rows="3" name="message" cols="25" class="txt_message" placeholder="Type message here"></textarea>
              </td>
              </tr>
              </table>
              <input type="hidden" name="registatoin_ids" value="{{$v->gcm_regid}}"/>
              <input type="submit" class="send_btn" value="Send" onclick=""/>
          </div>
      </form>
  <br/>
  <hr/>
  </li>
  
  {/foreach}
  </ul>
</div>