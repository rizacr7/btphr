function harga(nmobjek){
				a = $('#'+nmobjek).val();
				b = a.replace(/[^\d,-]/g,"");
				// b = b.replace(".",",");
				posisimin = b.indexOf("-");
				
				b0 = "";
				b1 = "";
				b2 = "";
				if(posisimin > 0){
					b = b.replace('-', '');
					posisimin = -1;
				}else if(posisimin == 0){
					b0 = b.substring(0, 1);
				}
				posisikoma = b.indexOf(",");
				// console.log("setelah - :"+b);
				if(posisikoma == -1){
					posisikoma = b.length;
				}else{
					b2 = b.substring(posisikoma, b.length);
				}
				b1 = b.substring((posisimin+1), posisikoma);
				
				// console.log("b0 : "+b0);
				// console.log("b1 : "+b1);
				// console.log("b2 : "+b2);
				c = "";
				panjang = b1.length;
				j = 0;
				for (i = panjang; i > 0; i--) {
					j = j + 1;
					if (((j % 3) == 1) && (j != 1)) {
						c = b1.substr(i-1,1) + "." + c ;
					} else {
						c = b1.substr(i-1,1) + c;
					}
				}
				// console.log("komposisi : "+b0+" "+c+" "+b2)
				$('#'+nmobjek).val(b0+c+b2);
			}
			
			