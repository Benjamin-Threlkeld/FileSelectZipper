// TOO MANY!! I need to learn how to fix this, maybe?
var checkboxes = document.getElementsByName('file[]'),
    result = document.getElementById('result'),
    checkboxCount = checkboxes.length-1,
    submitted = false,
    checked = false,
    checkedBoxesString,
    lastForm;

function validate() {
  // needed elements
  alertionerr = document.getElementById('alertionerr'),
  fileCheckederr = document.getElementById('fileCheckederr');
 
  console.log('validation');
  getCheckedBoxes();
  
  //show errors if needed, else make sure they are hidden
  var valid = true;
  
  if (checked == false) {
    fileCheckederr.innerHTML = 'Select at least one <- says javascript! :)';
    if ( ~fileCheckederr.className.indexOf('hidden')) {
      removeClass(fileCheckederr, 'hidden');
    }
    valid = false;
  } else {
    if (fileCheckederr.className.indexOf('hidden') == -1 ) {
      fileCheckederr.className += ' hidden';
    }
  }

  if (valid == false) {
    alertionerr.innerHTML = 'Error submitting the form';
    if ( ~alertionerr.className.indexOf('hidden')) {
      removeClass(alertionerr, 'hidden');
    }
  } else {
    if (alertionerr.className.indexOf('hidden') == -1 ) {
      alertionerr.className += ' hidden';
    }

    /*for (var i = window.thingymabobs.length - 1; i >= 0; i--) {
      window.thingymabobs[i].className += " hidden";
    };*/
  }
  return valid;
}

function getCheckedBoxes() {
  console.log("getting Checked boxes");
  checkedBoxes = [];
  checked = false;
  for (var i=checkboxCount;i>=0;i-=1) {
    // add checked boxes to checked, checkbox array
    if(checkboxes[i].checked) {
      checkedBoxes.push(i);
      checked = true;
    };
  };
  // flatten array with comma as delimiter
  checkedBoxesString = checkedBoxes.join(',');
}

function ajaxSubmit(form) {
  var xmlhttp;
  if (window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest();
  } else {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      result.innerHTML = xmlhttp.responseText;
      form.submitButton.disabled = false;
      form.submitButton.value = 'Zip Files';
      
      if (result.className.indexOf('fadeIn') == -1 ) {
        result.className += ' fadeIn';
      }
    }
  }
  xmlhttp.open("GET","index.php?a&s&files=" + checkedBoxesString, true);
  xmlhttp.send();
}
function runner(form) {
  if (validate()) {
    console.log('valid');
    // sending request, you don't need that button haha. So you can't resubmit with it anymore :)
    form.submitButton.disabled = true;
    form.submitButton.value = 'Please Wait...';
    // send the data!
    ajaxSubmit(form);
  } else {
    console.log('not valid');
  }
  return false;
}

function removeClass(el, className) {
  el.className = el.className.replace(className, '');
}

//if the select all checkbox is clicked
document.getElementById('selectAll').addEventListener("click", function() {
  //make all checkboxes have same state as selectAll
  for (var i=checkboxCount;i>=0;i-=1) {
    checkboxes[i].checked = this.checked;
  }
});