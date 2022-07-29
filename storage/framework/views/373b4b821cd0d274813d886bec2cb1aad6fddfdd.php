<van-swipe :height="150" class="my-swipe" :autoplay="5000" :duration="500" indicator-color="#0081ff" :autoplay="3000" indicator-color="white">
    <van-swipe-item v-for="(item,index) in swiperList" :key="index">
        <van-image :src="item.src" style="width:100%;height:100%;display:block;"/>
    </van-swipe-item>
</van-swipe>
