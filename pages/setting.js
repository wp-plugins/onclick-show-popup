/**
 *     Onclick show popup
 *     http://www.gopiplus.com/work/2011/12/17/wordpress-plugin-onclick-show-popup-for-content/
 *     Copyright (C) 2011 - 2013 www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


function OnclickShowPopup_submit()
{
	if(document.OnclickShowPopup_form.OnclickShowPopup_title.value=="")
	{
		alert("Please enter the popup title.")
		document.OnclickShowPopup_form.OnclickShowPopup_title.focus();
		return false;
	}
	else if(document.OnclickShowPopup_form.OnclickShowPopup_text.value=="")
	{
		alert("Please enter the popup message.")
		document.OnclickShowPopup_form.OnclickShowPopup_text.focus();
		return false;
	}
	else if(document.OnclickShowPopup_form.OnclickShowPopup_status.value == "" || document.OnclickShowPopup_form.OnclickShowPopup_status.value == "Select")
	{
		alert("Please select the display status.")
		document.OnclickShowPopup_form.OnclickShowPopup_status.focus();
		return false;
	}
	else if(document.OnclickShowPopup_form.OnclickShowPopup_group.value == "" || document.OnclickShowPopup_form.OnclickShowPopup_group.value == "Select")
	{
		alert("Please select popup group, this is to group the popup message..")
		document.OnclickShowPopup_form.OnclickShowPopup_group.focus();
		return false;
	}
}

function OnclickShowPopup_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_OnclickShowPopup_display.action="options-general.php?page=onclick-show-popup&ac=del&did="+id;
		document.frm_OnclickShowPopup_display.submit();
	}
}	

function OnclickShowPopup_redirect()
{
	window.location = "options-general.php?page=onclick-show-popup";
}

function OnclickShowPopup_help()
{
	window.open("http://www.gopiplus.com/work/2011/12/17/wordpress-plugin-onclick-show-popup-for-content/");
}