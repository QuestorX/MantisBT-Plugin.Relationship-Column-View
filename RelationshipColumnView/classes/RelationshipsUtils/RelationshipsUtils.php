<?php

define ('RELATIONSHIPS_UTILS_PLUGIN_URL', 'plugins' . DIRECTORY_SEPARATOR . 'RelationshipColumnView' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'RelationshipsUtils' . DIRECTORY_SEPARATOR);

/**
 * Class roadmap_pro_api
 *
 * provides functions to calculate and process data
 *
 * @author Rainer Dierck
 */
class RelationshipsUtils
{
   /**
    * checks relationships for a bug and assign relevant symbols
    *
    * @author Rainer Dierck
    * @param $bugId
    */
   public static function echoBugSmybols ( $bugId, $p_newline = false )
   {
      $t_text = '';
      $bugStatus = bug_get_field ( $bugId, 'status' );
      $allRelationships = relationship_get_all ( $bugId, $t_show_project );
      $allRelationshipsCount = count ( $allRelationships );
      $stopFlag = false;
      $forbiddenFlag = false;
      $warningFlag = false;
      $bugEta = bug_get_field ( $bugId, 'eta' );
      $useEta = ( $bugEta != ETA_NONE ) && config_get ( 'enable_eta' );
      $stopAltText = "";
      $forbiddenAltText = "";
      $warningAltText = "";
      $href = string_get_bug_view_url ( $bugId ) . '#relationships_open';

      for ( $index = 0; $index < $allRelationshipsCount; $index++ )
      {
         $relationShip = $allRelationships [ $index ];
         if ( $bugId == $relationShip->src_bug_id )
         {  # root bug is in the src side, related bug in the dest side
            $destinationBugId = $relationShip->dest_bug_id;
            $relationshipDescription = relationship_get_description_src_side ( $relationShip->type );
         }
         else
         {  # root bug is in the dest side, related bug in the src side
            $destinationBugId = $relationShip->src_bug_id;
            $relationshipDescription = relationship_get_description_dest_side ( $relationShip->type );
         }

         # get the information from the related bug and prepare the link
         $destinationBugStatus = bug_get_field ( $destinationBugId, 'status' );
         if (  ( $bugStatus < CLOSED )
            && ( $destinationBugStatus < CLOSED )
            && ( $relationShip->type != BUG_REL_NONE )
         )
         {
            if ( $relationShip->type == BUG_DEPENDANT )
            {
               if ( $bugId == $relationShip->src_bug_id )
               {  // Stop or Forbidden
                  if ( $bugStatus == $destinationBugStatus )
                  {  // Stop
                     if ( $stopAltText != "" )
                     {
                        $stopAltText .= ", ";
                     }
                     if ( !$stopFlag )
                     {
                        $stopAltText .= trim ( utf8_str_pad ( $relationshipDescription, 20 ) ) . ' ';
                     }
                     $stopAltText .= string_display_line ( bug_format_id ( $destinationBugId ) );
                     $stopFlag = true;
                  }
                  if ( $bugStatus > $destinationBugStatus )
                  {  // Forbidden
                     if ( $forbiddenAltText != "" )
                     {
                        $forbiddenAltText .= ", ";
                     }
                     if ( !$forbiddenFlag )
                     {
                        $forbiddenAltText .= trim ( utf8_str_pad ( $relationshipDescription, 20 ) ) . ' ';
                     }
                     $forbiddenAltText .= string_display_line ( bug_format_id ( $destinationBugId ) );
                     $forbiddenFlag = true;
                  }
               }
               else
               {  // Warning
                  if ( $bugStatus < $destinationBugStatus )
                  {  // Warning
                     if ( $warningAltText != "" )
                     {
                        $warningAltText .= ", ";
                     }
                     if ( !$warningFlag )
                     {
                        $warningAltText .= trim ( utf8_str_pad ( $relationshipDescription, 20 ) ) . ' ';
                     }
                     $warningAltText .= string_display_line ( bug_format_id ( $destinationBugId ) );
                     $warningFlag = true;
                  }
               }
            }
         }
      }

      //if ( $useEta )
      //{  // RELATIONSHIPS_UTILS_PLUGIN_URL
      //   $t_text .= '<img border="0" width="16" height="16" src="' . RELATIONSHIPS_UTILS_PLUGIN_URL . 'clock.png' . '" alt="clock" />';
      //}
      if ( $forbiddenFlag )
      {
         if ($p_newline && !is_blank ($t_text))
            $t_text .= '<br/>' . "\n";
         $t_text .= '<a href="' . $href . '"><img border="0" width="16" height="16" src="' . RELATIONSHIPS_UTILS_PLUGIN_URL . 'sign_forbidden.png" alt="' . $forbiddenAltText . '" title="' . $forbiddenAltText . '" /></a>';
      }
      if ( $stopFlag )
      {
         if ($p_newline && !is_blank ($t_text))
            $t_text .= '<br/>' . "\n";
         $t_text .= '<a href="' . $href . '"><img border="0" width="16" height="16" src="' . RELATIONSHIPS_UTILS_PLUGIN_URL . 'sign_stop.png" alt="' . $stopAltText . '" title="' . $stopAltText . '" /></a>';
      }
      if ( $warningFlag )
      {
         if ($p_newline && !is_blank ($t_text))
            $t_text .= '<br/>' . "\n";
         $t_text .= '<a href="' . $href . '"><img border="0" width="16" height="16" src="' . RELATIONSHIPS_UTILS_PLUGIN_URL . 'sign_warning.png" alt="' . $warningAltText . '" title="' . $warningAltText . '" /></a>';
      }
      
      return $t_text;
   }
}
