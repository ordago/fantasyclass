<!DOCTYPE html>
<html>

<head>
<style>
  body {
    overflow: hidden;
    padding: 0;
    margin: 0;
    /* width: 33px;
    height: 49px; */
    text-align: center;
  }
</style>

</head>
<body>
  @if(isset($check))
    @if($check !== "invisible")
      <a href="{{ $permalink }}" target="_blank">
        @if($check)
          <img width="100%" title="{{ $title }}" src="/img/maps/marker-ok.png" alt="marker">
        @else
          <img width="100%" title="{{ $title }}" src="/img/maps/marker-ko.png" alt="marker">
        @endif
      </a>
      @endif
  @else
    <img width="100%" src="/img/maps/marker.png" alt="marker">
  @endif
</body>

</html>