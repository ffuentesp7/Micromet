//This script and many more are available free online at -->
//The JavaScript Source!! http://javascript.internet.com -->
//Created by: Lee Hinder, lee.hinder@ntlworld.com -->

//set todays date
Now = new Date();
NowDay = Now.getDate();
NowMonth = Now.getMonth();
NowYear = Now.getYear();
if(NowYear < 2000) 
	NowYear += 1900; //for Netscape

//function for returning how many days there are in a month including leap years
function DaysInMonth(WhichMonth, WhichYear)
{
	var DaysInMonth = 31;
	if (WhichMonth == "Abr" || WhichMonth == "Jun" || WhichMonth == "Sep" || WhichMonth == "Nov") 
  		DaysInMonth = 30;
	if (WhichMonth == "Feb" && (WhichYear/4) != Math.floor(WhichYear/4))	
  		DaysInMonth = 28;
	if (WhichMonth == "Feb" && (WhichYear/4) == Math.floor(WhichYear/4))	
  		DaysInMonth = 29;
	return DaysInMonth;
}

//function to change the available days in a months
function ChangeOptionDays(Which)
{
	DaysObject = eval("document.Form1." + Which + "Day");
	MonthObject = eval("document.Form1." + Which + "Month");
	YearObject = eval("document.Form1." + Which + "Year");

	Month = MonthObject[MonthObject.selectedIndex].text;
	Year = YearObject[YearObject.selectedIndex].text;

	DaysForThisSelection = DaysInMonth(Month, Year);
	CurrentDaysInSelection = DaysObject.length;
	if (CurrentDaysInSelection > DaysForThisSelection){
		for (i=0; i<(CurrentDaysInSelection-DaysForThisSelection); i++){
			DaysObject.options[DaysObject.options.length - 1] = null
		}
	}
	if (DaysForThisSelection > CurrentDaysInSelection){
		var topIndex = DaysForThisSelection-CurrentDaysInSelection;
		for (i=0; i<topIndex; i++){
			NewOption = new Option(DaysObject.options.length + 1,DaysObject.options.length + 1);
			DaysObject[DaysObject.options.length] = NewOption;
		}
	}
	if (DaysObject.selectedIndex < 0) 
		DaysObject.selectedIndex == 0;
}

//function to set options to today
function SetToToday(Which)
{
	DaysObject = eval("document.Form1." + Which + "Day");
	MonthObject = eval("document.Form1." + Which + "Month");
	YearObject = eval("document.Form1." + Which + "Year");
	
	YearObject[YearObject.options.length - 1].selected = true;
	MonthObject[NowMonth].selected = true;

	ChangeOptionDays(Which);

	DaysObject[NowDay-1].selected = true;
}

//function to write option years plus x
function WriteYearOptions(YearsAhead)
{
	var startYear = 2008;
	line = "";
	for (i=startYear; i<=NowYear; i++){
		if(NowYear == i){
			line += "<OPTION selected=\"true\" value=\""+ i +"\">";
			line += i;
			line += '</OPTION>';
		}
		else{
			line += "<OPTION value=\""+ i +"\">";
			line += i;
			line += '</OPTION>';
		}
	}
	return line;
}

function GetDateFromForm(Which,Field)
{
	var fecha = '';
	DaysObject = eval("document.Form1." + Which + "Day");
	MonthObject = eval("document.Form1." + Which + "Month");
	YearObject = eval("document.Form1." + Which + "Year");
	
	fecha += YearObject[YearObject.selectedIndex].value;
	fecha += '-';
	fecha += MonthObject[MonthObject.selectedIndex].value;
	fecha += '-';
	fecha += GetTextDay(DaysObject[DaysObject.selectedIndex].value);
	
	document.getElementById(Field).value = fecha;
}

function GetTextDay(day)
{
	if(day < 10)
		return "0" + day;
	else
		return day;

}