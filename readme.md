#Frenet Plugin for craft commerce

This is an alpha implementation of frenet.com.br API with craft commerce.

How to use it: 

### Address lookup with CEP
Post via ajax to `/actions/frenet/cep`
The form should have an input named `cep`

### Check available Shipping methods
Post via ajax to `/actions/frenet/shippingInfo`

Todo: 

- Check for errors/not valid CEP before hitting API
- Map CEP lookup response to cep-promise's
- Shipping quotes
- Tracking info