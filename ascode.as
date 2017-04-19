var padding:Number=10;
var startX:Number=99;
var startY:Number=155;
var questionNum:Number=0;

function buildMenu() {
	//Create a new movieclip
	newQuestion = new TextField();
	newQuestion.width = 250;
	newQuestion.height = 30;
	newQuestion.wordWrap = true;
	//Store the name of the image and title in variables inside the movieclip
	newQuestion.text = xml.question[questionNum];
	tFormat = new TextFormat();
	tFormat.font = "Arial";
	tFormat.size = 18;
	tFormat.align=center;
	
	
	newQuestion.setTextFormat (tFormat);
	//Add the thumbLoader object to the newQuestion movieclip
	addChild(newQuestion);
	//Add the newQuestion movieclip to the stage
	//addChild(newQuestion);
	//Position the newQuestion movieclip
	newQuestion.x=startX;
	newQuestion.y=startY;
	//Increment the startX variable by the width of the newQuestion movieclip and the specified padding
	startY+=newQuestion.height+padding;
	//Incremembt the thumbNum variable
	questionNum++;
	//Check if thumbNum is less than the number of photos in the xml object
	if (questionNum<xml.question.length()) {
		//If photos are left, call the buildMenu function again to add more thumbnails
		buildMenu();
	}
	}