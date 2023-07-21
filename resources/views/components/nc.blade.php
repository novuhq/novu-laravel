<notification-center-component
      style="{{ $style ?? '' }}"
      application-identifier="{!! $appId ?? '' !!}"
      subscriber-id="{!! $subscriberId ?? '' !!}"
    ></notification-center-component>


<script type="text/javascript">
    let nc = document.getElementsByTagName('notification-center-component')[0];
    nc.onLoad = () => console.log('notification center loaded!');
</script>