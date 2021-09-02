<!DOCTYPE html>
<html>

<head></head>
<style>
  body {
    overflow: hidden;
    padding: 0;
    margin: 0;
    width: 33px;
    height: 49px;
    text-align: center;
  }
</style>

<body>
  @if(isset($check) && $check !== "invisible")
    <a href="{{ $permalink }}" target="_blank">
      @if($check)
      <img width="33px" height="49px" src="/img/maps/marker-ok.png" alt="marker">
      @else
      <img width="33px" height="49px" src="/img/maps/marker-ko.png" alt="marker">
      @endif
    </a>
  @elseif($check !== "invisible")
    <img width="33px" height="49px" src="/img/maps/marker.png" alt="marker">
  @endif
</body>

</html>