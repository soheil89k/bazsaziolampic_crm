<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="no-mtop mbot15">
   <?php echo _l('gdpr_right_to_erasure'); ?>
    <small>
        <a href="https://ico.org.uk/for-organisations/guide-to-the-general-data-protection-regulation-gdpr/individual-rights/right-to-erasure/" target="_blank"><?php echo _l('learn_more'); ?></a>
    </small>
</h4>
<ul class="nav nav-tabs tabs-in-body-no-margin" role="tablist">
    <li role="presentation" class="active">
       <a href="#forgotten_options" aria-controls="forgotten_options" role="tab" data-toggle="tab">
          تنظیمات
      </a>
  </li>
  <li role="presentation">
   <a href="#removal_requests" aria-controls="removal_requests" role="tab" data-toggle="tab">
       درخواست های حذف
       <?php if($not_pending_requests > 0){ ?>
       <span class="badge"><?php echo $not_pending_requests; ?></span>
       <?php } ?>
   </a>
</li>
</ul>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="forgotten_options">
        <h4 class="no-mtop">مخاطبین</h4>
        <hr class="hr-panel-heading">
        <?php render_yes_no_option('gdpr_contact_enable_right_to_be_forgotten','مخاطب قادر باشد درخواست حذف داده ها را ارسال کند'); ?>
        <hr />
        <?php render_yes_no_option('gdpr_on_forgotten_remove_invoices_credit_notes','هنگام حذف مشتری، <b>فاکتورها</b> و <b>یادداشت های اعتباری</b> مرتبط با او را هم حذف کن.'); ?>
        <hr />
        <?php render_yes_no_option('gdpr_on_forgotten_remove_estimates','هنگام حذف مشتری، پیش فاکتور های مرتبط با او را هم حذف کن.'); ?>
        <hr class="hr-panel-heading">
        <h4>مشتریان بالقوه</h4>
        <hr class="hr-panel-heading">
        <?php render_yes_no_option('gdpr_lead_enable_right_to_be_forgotten','مشتری بالقوه قادر باشد درخواست حذف داده ها را ارسال کند (از طریق فرم عمومی)'); ?>
        <hr />
        <?php render_yes_no_option('gdpr_after_lead_converted_delete','پس از تبدیل مشتری باقوه به مشتری، همه اطلاعات مشتری باقوه را حذف کن'); ?>
        <hr />
    </div>
    <div role="tabpanel" class="tab-pane" id="removal_requests">
        <table class="table dt-table" data-order-type="desc" data-order-col="4">
            <thead>
                <tr>
                    <th>شناسه درخواست</th>
                    <th>درخواست از طرف</th>
                    <th>توضیحات</th>
                    <th>وضعیت درخواست</th>
                    <th>تاریخ درخواست</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($requests as $request) { ?>
                <tr>
                    <td data-order="<?php echo $request['id']; ?>"><?php echo $request['id']; ?></td>
                    <td><?php echo $request['request_from']; ?>
                        <?php if(!empty($request['contact_id'])) {
                            echo '<span class="label label-info pull-right">Contact</span>';
                        } else if(!empty($request['lead_id'])) {
                            echo '<span class="label label-info pull-right">Lead</span>';
                        }
                        ?>
                    </td>
                    <td><?php echo $request['description']; ?></td>
                    <td data-order="<?php echo $request['status']; ?>">
                        <select class="selectpicker removalStatus" name="status" data-id="<?php echo $request['id']; ?>"  width="100%">
                            <option value="pending"<?php if($request['status'] == 'pending'){echo ' selected';} ?>>در انتظار</option>
                            <option value="removed"<?php if($request['status'] == 'removed'){echo ' selected';} ?>>حذف شده</option>
                            <option value="refused"<?php if($request['status'] == 'refused'){echo ' selected';} ?>>رد شده</option>
                        </select>
                    </td>
                    <td data-order="<?php echo $request['request_date']; ?>"><?php echo _dt($request['request_date']); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>
