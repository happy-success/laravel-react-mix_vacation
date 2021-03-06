import React from 'react';
import ReactDOM from 'react-dom';
import paypal from 'paypal-checkout';
import  { Redirect } from 'react-router-dom'
const PayPalButton = paypal.Button.driver('react', {React, ReactDOM});
function formEncode(form) {
    var ret = {};
    Object.keys(form.elements).forEach(function (key) {
      ret[form.elements[key].name] = form.elements[key].value;
    });
    return ret;
  }
  const token = document.querySelector('meta[name="csrf-token"]');
export default class PayPalCheckout extends React.Component {
    constructor(props) {
      super(props)
      this.state = {
        subscriptiontype : this.props.planId,
        subscribe_success : false
      }
      this.payment = this.payment.bind(this)
      this.onAuthorize = this.onAuthorize.bind(this)
    }

    onAuthorize(data, actions) {
        console.log(data);
      
        let self = this;
        return  paypal.request.post('/ajax/paypal/subscribe/excute?token='+data.orderID+'&planId='+this.props.planId+'&roomId='+this.props.roomId,{token : data.orderID}, 
        {
          headers: { 
            'X-CSRF-TOKEN': token.content 
          }
        })
          .then(function (response) {
              self.props.paymentSuccess()
              return response;

          });
    }

    payment() {
      // console.log(this.props.planId,'sssssssssss')
        let planId = this.props.planId
        let roomId = this.props.roomId
        // let self = this
          return new paypal.Promise(function(resolve, reject) {
            return  paypal.request.post('/ajax/rooms/post_subscribe_property_paypal/create_plan' ,{roomId :  roomId, planId : planId},{
              headers: { 
              
                'X-CSRF-TOKEN': token.content 
              }
            })
            .then(function (response) {
                resolve(response) ;
            });
        });
    }

    render() {
      
        const client = {
            sandbox: 'Af-PimPKghDsdMCwvPPjQYnsjNBv_jbxBRfWjXeFmWxCmlmXSUCOjwBAU-GOsPJHC5g0KHECJuPwqEqv',
            production: 'EBXItHpMuh_Yn0rcNWscu7i1RFYg2z_q5iy1nLFtL6dUiKyr2f9yrkMfRvhp0CxySoiRwa6CRrH2zKVp'
        };
        // if(this.state.subscribe_success){
        //     return <Redirect to='/pricing'  />
        // }
        
        return (
            <PayPalButton env={'sandbox'}
                          client={client}
                          payment={this.payment}
                          commit={true} // Optional: show a 'Pay Now' button in the checkout flow
                          onAuthorize={this.onAuthorize}/>
                     
                          
        );
    }
}
 
 