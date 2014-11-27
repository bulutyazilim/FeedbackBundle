$(document).ready ->
  buttons =
    remove: $(".feedback-delete")
    mark_as_read: $(".feedback-mark-as-read")
    mark_as_done: $(".feedback-mark-as-done")
    show_content: $(".feedback-show-content")

  buttons.remove.on 'click', ->
    feedback.remove $(this).data 'content-id'

  buttons.mark_as_done.on 'click', ->
    feedback.mark_as.done $(this).data 'content-id'

  buttons.mark_as_read.on 'click', ->
    feedback.mark_as.read $(this).data 'content-id'

  buttons.show_content.on 'click', ->
    feedback.show_content $(this).data 'content-id'

  return;

feedback =
  remove: (id)->
    sure = confirm("Are you sure?")
    if(!sure)
      return false
    $.ajax
      url: "/admin/feedback/remove/#{id}"
      type: "DELETE"
      dataType: 'json'
      success: (rd)->
        if rd.status
          document.location.reload()
        else
          alert 'An error has occured'
    return false
  show_content: (id)->
    $("#entity_#{id}").slideToggle()
    return false
  mark_as:
    read: (id)->
      $.ajax
        url: "/admin/feedback/mark/read/#{id}"
        type: "GET"
        dataType: "json"
        success: (rd)->
          if rd.status
            document.location.reload()
          else
            alert 'An error has occured'
      return false
    done: (id)->
      $.ajax
        url: "/admin/feedback/mark/done/#{id}"
        type: "GET"
        dataType: "json"
        success: (rd)->
          if rd.status
            document.location.reload()
          else
            alert 'An error has occured'
      return false