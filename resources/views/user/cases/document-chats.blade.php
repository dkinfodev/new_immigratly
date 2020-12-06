@foreach($chats as $chat)
@if($chat['created_by'] != Auth::user()->unique_id)
<li class="message left appeared">
   <span class="avatar avatar-sm avatar-circle">
     <img class="avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
   </span>
   <div class="text_wrapper">
      @if($chat['type'] == 'text')
      <div class="text">{{$chat['message']}}</div>
      @else
      <div class="text">
         <?php
            $file_url = professionalDirUrl($subdomain)."/documents/".$chat['file_detail']['file_name'];
         ?>
         <a href="{{$file_url}}" download>
         <?php 
            $fileicon = fileIcon($chat['message']);
            echo $fileicon;
         ?>
         {{$chat['message']}}
         </a>
      </div>
      @endif
   </div>
</li>
@else
<li class="message right appeared">
   <span class="avatar avatar-circle">
     <img class="avatar-img" src="{{ userProfile(Auth::user()->unique_id,'t') }}" alt="Image Description">
   </span>
   <div class="text_wrapper">

      @if($chat['type'] == 'text')
      <div class="text">{{$chat['message']}}</div>
      @else
      <div class="text">
         <?php
            $file_url = professionalDirUrl($subdomain)."/documents/".$chat['file_detail']['file_name'];
         ?>
         <a href="{{$file_url}}" download>
         <?php 
            $fileicon = fileIcon($chat['message']);
            echo $fileicon;
         ?>
         {{$chat['message']}}
         </a>
      </div>
      @endif
   </div>
</li>
@endif
@endforeach