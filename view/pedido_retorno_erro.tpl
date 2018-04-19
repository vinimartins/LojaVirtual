
<h3 class="text-center text-danger"> Ocorreu um problema no pagamento, ou foi cancelado</h3>
<hr>
<section  class="row">
    
    <div class="col-md-3"></div>
   
    
    <div class="col-md-6">
        
          <p>Caso houve algum problema, por gentileza entre em contato conosco, informando <br>
        o código de referência:<b> {$REF} </b>
        </p> 
        
         <p> Ou pode tentar novamente o pagamento na seção "<strong>Pedidos</strong>" clicando em "<strong>Detalhes</strong>",<br>
         verá seus itens comprados e  abaixo o botão "<strong>Completar Pagamento Agora</strong>".
        </p>  
        
         <p> Para ir à tela do pedido e efetuar o pagamento, clique no botão.</p>  
         <p>
         <form name="pagamento" method="post" action="{$PAG_ITENS}">
             <input type="hidden" name="cod_pedido" value="{$REF}">  
             <button class="btn btn-success btn-block btn-lg"> Fazer Pagamento Agora</button>
                 
             
             
         </form>        
             
             
         </p>
        
        
        
    </div>
    <div class="col-md-3"></div>
    
    
    
    
    
</section>
