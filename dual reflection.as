import com.adobe.images.JPGEncoder;
import com.dynamicflash.util.Base64;

var localIP:String = "localhost"

var customClient:Object = new Object();
customClient.onMetaData=metaDataHandler;
var videoFolder:Number = parent.vidFolder
var videoID:String = parent.vidID
var userID:Number = parent.loginID
var now:Date = new Date();
var nc:NetConnection;
var ns1:NetStream;
var ns2:NetStream;
var video:Video = new Video();
var video2:Video = new Video();
var camera:Camera=Camera.getCamera();
nc = new NetConnection();
nc.connect("rtmp://localhost/VideoRecorder");
nc.addEventListener(NetStatusEvent.NET_STATUS, doNetStatus);
//Setting up viodeo player #1
viewVideo.playBut.alpha=0;
viewVideo.pauseBut.alpha=0;
viewVideo.addChild(video);
viewVideo.video.x=73;
viewVideo.video.y=23;
viewVideo.video.height=186;
viewVideo.video.width=269;
//Setting up Recording area
mont =now.getUTCMonth()
day=now.getUTCDate()
year=now.getUTCFullYear()
hour=now.getUTCHours()
minute=now.getUTCMinutes()
sec=now.getUTCSeconds()
month = mont+1
var timeStamp:String=userID+"_"+month+""+day+""+year+""+hour+""+minute+""+sec
//trace(month+1+""+day+""+year)
//Setting up cam picture

var bmd:BitmapData=new BitmapData(320,240);
var ba:ByteArray;
var jpgEncoder:JPGEncoder=new JPGEncoder();
var byteArrayAsString:String;
var camera:Camera=Camera.getCamera();
camera.setQuality(0, 90);
camera.setKeyFrameInterval(15)
camera.setMode(320, 240,18,true);
camera.setLoopback(false)
var mic = Microphone.getMicrophone();

video2.attachCamera(camera);
reflection.addChild(video2);
reflection.video2.x=73;
reflection.video2.y=23;
reflection.video2.height=186;
reflection.video2.width=269;
reflection.record_btn.addEventListener(MouseEvent.MOUSE_DOWN, doRecord);

function doNetStatus(e:NetStatusEvent):void {
	//status_txt.text=e.info.code;
	if (e.info.code=="NetConnection.Connect.Success") {
		viewVideo.playBut.alpha=.5;
		viewVideo.pauseBut.alpha=.5;
		ns2=new NetStream(nc);
		ns2.client=customClient;
		viewVideo.video.attachNetStream(ns2);
		viewVideo.video.smoothing=true;
		ns2.play(videoFolder+"/"+videoID+"_v",.05);
		ns2.pause();
		ns1 = new NetStream(nc);
		ns1.attachAudio(mic);
		ns1.attachCamera(camera);
	}
}
function metaDataHandler(infoObject:Object):void {
}

function doRecord(event:MouseEvent):void
		{
			if (event.target)
			{
				ns1.publish(userID+"/"+timeStamp+"_v","record");
				saveStill()
			}
			else
			{
				ns1.close();
			}
		}

function moveThumb():void {
	userPicLoader = new URLLoader();
	userPicRequest=new URLRequest("http://"+localIP+"/reflektii/reflectresponcevidpic.php");
	userPicRequest.method=URLRequestMethod.POST;
	userPicLoader.dataFormat=URLLoaderDataFormat.TEXT;
	userPicVars = new URLVariables();

	//Add login data to loginVars
	userPicVars.videoID=videoID
	userPicVars.userID=userID
	userPicVars.timestamp=timeStamp
	userPicVars.flashpic=byteArrayAsString;
	userPicRequest.data=userPicVars;
	//trace(userPicVars.userID)
	//Send info to PHP
	userPicLoader.load(userPicRequest);
	userPicLoader.addEventListener(Event.COMPLETE, userPicComplete);
	userPicLoader.addEventListener(IOErrorEvent.IO_ERROR, userPicError);

}

function userPicComplete(event:Event):void {
			trace("I think it worked");
	}

function userPicError(event:IOErrorEvent):void {
	trace("something went horribly wrong");
}


function saveStill(event:MouseEvent):void {
	bmd.draw(reflection.video2);
	ba=jpgEncoder.encode(bmd);
	byteArrayAsString=Base64.encodeByteArray(ba);
	//trace(byteArrayAsString);
	moveThumb();
}
		
viewVideo.playBut.buttonMode=true;
viewVideo.playBut.useHandCursor=true;
viewVideo.playBut.mouseChildren=false;

viewVideo.playBut.addEventListener(MouseEvent.ROLL_OVER, onOver);
viewVideo.playBut.addEventListener(MouseEvent.ROLL_OUT, onOut);
viewVideo.playBut.addEventListener(MouseEvent.MOUSE_DOWN, onclick);

viewVideo.pauseBut.buttonMode=true;
viewVideo.pauseBut.useHandCursor=true;
viewVideo.pauseBut.mouseChildren=false;

viewVideo.pauseBut.addEventListener(MouseEvent.ROLL_OVER, onOver);
viewVideo.pauseBut.addEventListener(MouseEvent.ROLL_OUT, onOut);
viewVideo.pauseBut.addEventListener(MouseEvent.MOUSE_DOWN, onclick);

function onclick(event:MouseEvent) {
	if (event.target.name=="playBut") {
		ns2.resume();
	}
	if (event.target.name=="pauseBut") {
		ns2.pause();
	}
}

function onOver(event:MouseEvent) {
	if (event.target) {
		Tweener.addTween(event.target,{alpha: 1, time:.2, transition:"easeOutQuad"});
	}
}

function onOut(event:MouseEvent) {
	if (event.target) {
		Tweener.addTween(event.target,{alpha: .5, time:.2, transition:"easeOutQuad"});
	}
}