<notification-center-component
      style="{{ $style }}"
      application-identifier="{!! $appId !!}"
      subscriber-id="{!! $subscriberId !!}"
    ></notification-center-component>


<script type="text/javascript">
    // here you can attach any callbacks, interact with the web component API
    let nc = document.getElementsByTagName('notification-center-component')[0];
    nc.onLoad = () => console.log('hello world!');
</script>