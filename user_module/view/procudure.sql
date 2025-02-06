CREATE OR REPLACE PROCEDURE DEVELOPERS."RML_COLL_CCD_DATA_SYN" 
IS
BEGIN
   DELETE FILESUM_ERP;

   INSERT INTO FILESUM_ERP
      SELECT * FROM FILESUM_V@ERP_LINK_LIVE;
      
      DELETE LEASE_ALL_INFO_ERP;
      
      INSERT INTO LEASE_ALL_INFO_ERP
      SELECT * FROM lease_all_info@ERP_LINK_LIVE;
      
      DELETE BUYERS_ALL_INFO_DATA;
      INSERT into  BUYERS_ALL_INFO_DATA
      select * FROM  BUYERS_ALL_INFO_DATA@ERP_LINK_LIVE;
      
     
    CCD_REQUEST_DATE_UPDATE();
    
    
    /*====== For Garimela Data Update=============*/
    DELETE RESALE.PRE_PRODUCT;
    INSERT INTO RESALE.PRE_PRODUCT SELECT * FROM RE_SALES_STOCK@ERP_LINK_LIVE;
    RESALE.RESALE_PRODUCT_UPDATE('');
    /*======End For Garimela Data Update=============*/
    
    
    
    INSERT INTO DATA_SYN_LOG (
              NOTE_REMARKS, 
              CREATE_DATE, 
              CREATED_ID, 
              PROCESS_LOG) 
            VALUES (  
              'Manual Data Process',
              SYSDATE,
              '',
              'RML_COLL_CCD_DATA_SYN' );

      
END;
/