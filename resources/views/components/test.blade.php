<div class="alert alert-{{$type}}">

  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad animi deserunt dolorum, earum excepturi impedit, in ipsum laboriosam maiores minima minus, natus necessitatibus optio placeat provident quaerat sint suscipit voluptas?</p>
   {{$slot}}
   @if($isClose())
       closeable button
       @endif
</div>
