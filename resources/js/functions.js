
/*================
  Functions
=================*/

function createP(text , classes = null, ids = null, styles = null){
  let cl = classes ? `class='${classes}'`: '',
  id = ids ? `id='${ids}'` :'',
  style = styles ? `style='${styles}'` : '';

  return `<p ${cl} ${id} ${style}> ${text} </p>`;
}

function foo(){
  console.log("foo")
}


function log(log){
  console.log(log)
}
