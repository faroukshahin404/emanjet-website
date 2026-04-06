   <!-- cancel Modal -->
   <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true"
       data-bs-backdrop="false">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header d-flex align-items-center">
                   <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>

               <div class="modal-body cancel-reserve d-flex flex-column align-items-center gap-2">
                   <div class="confirm-icon-box">
                       <i class="fas fa-check"></i>
                   </div>
                   <p class="text-black mb-2">{{ __('Booking has been cancelled.') }}</p>
                   <h6>{{ __('Refund will be returned to your original payment method within 7 business days.') }}</h6>

               </div>
           </div>
       </div>
   </div>
